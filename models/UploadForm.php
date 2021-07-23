<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
    * @var UploadedFile
    */
    public $csvFile;

    protected $participants;
    protected $suspects;
    protected $crimes = [];

    public function rules()
    {
        return [
            'csvfile' => [['csvFile'], 'file', 'skipOnEmpty' => false, 'extensions' => null],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->csvFile->saveAs('uploads/' . $this->csvFile->baseName . '.' . $this->csvFile->extension);
            return true;
        } else {
            return false;
        }
    }

    private function addDataToDB()
    {
        foreach($this->crimes as $key => $crime) {
            $item = explode(',', $crime[0]);
            $date = date_create($item[3]);
            Yii::$app->db->createCommand()->insert('crimes', [
                'code_id' => $item[0],
                'crime_name' => $item[1],
                'crime_number' => $item[2],
                'crime_date' => date_format($date,"Y-m-d"),
                'crime_location' => $item[4],
                'lat' => $item[5],
                'long' => $item[6],
            ])->execute();

            $id = Yii::$app->db->getLastInsertID();
            if ($id) {
                $suspects = explode('|', $this->suspects[$key]);
                foreach($suspects as $k => $person) {
                    Yii::$app->db->createCommand()->insert('suspects', [
                        'crime_id' => $id,
                        'code_link_id' => $item[0],
                        'quantity' => $this->participants[$key],
                        'name' => $person,
                    ])->execute();
                }
            }
        }
    }

    public function parseCsv()
    {
        $fp = fopen('uploads/' . $this->csvFile->baseName . '.' . $this->csvFile->extension, 'r');
        if ($fp) {
            $c = 0;
            for ($i = 0; $row = fgetcsv($fp, 0, "\n"); ++$i) {
                if ($i == 0) {
                    $str = $row[0];
                    $this->participants = explode(",", substr($str, strpos($str, ","), strlen($str)));
                }
                if ($i == 1) {
                    $str = $row[0];
                    $this->suspects = explode(",", substr($str, strpos($str, ","), strlen($str)));
                }
                if ($i > 3) {
                   $this->crimes[$c] = $row;
                   $c++;
                }
            }
            fclose($fp);

            if (isset($this->crimes)) {
                $this->addDataToDB();
            }
        }

        unlink(Yii::$app->basePath . '/web/uploads/' .$this->csvFile->baseName . '.' . $this->csvFile->extension);
    }
}
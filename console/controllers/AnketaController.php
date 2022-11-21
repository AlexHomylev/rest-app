<?php


namespace console\controllers;

use common\helpers\FileHelper;
use common\models\Anketa;
use common\models\AnketaFile;
use yii\console\Controller;
use yii\db\Exception;

class AnketaController extends Controller
{
    /**
     * Удаление документов обработанных анкет за последние три дня
     */
    public function actionDeleteOldFiles()
    {
        $anketas = Anketa::find()
            ->where(['is_processed' => true])
            ->andWhere([
                '<',
                'created_at',
                date('Y-m-d H:i:s', strtotime('-3 days')),
            ])
            ->andWhere(['not', ['docs' => null]]);

        $transaction = \Yii::$app->db->beginTransaction();

        try {
            foreach ($anketas->each() as $anketa) {
                foreach ($anketa->docs as $docName) {
                    $filePath = Anketa::getDocsPath() . "/{$docName}";

                    if (file_exists($filePath)) {
                        FileHelper::unlink($filePath);
                    }

                    if (\Yii::$app->s3Client->fileExist($docName)) {
                        \Yii::$app->s3Client->delete($docName);
                    }

                    $anketa->docs = null;
                    $anketa->save();
                }
            }

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            \Yii::error('Ошибка сохранения анкеты при удалении файлов: ' . $e->getMessage());
        }
    }
}

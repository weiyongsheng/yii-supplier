<?php namespace app\controllers;

use app\models\ExportForm;
use app\models\Supplier;
use yii\web\Controller;

class SupplierController extends Controller
{
    /**
     * 厂商列表
     *
     * @return string
     */
    public function actionIndex()
    {
        $params = $this->request->get();
        $searchModel = new Supplier();
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'condition'    => $this->encodeCondition($params),
        ]);
    }

    /**
     * 导出页面
     *
     * @return string
     */
    public function actionExportPage()
    {
        $model = new ExportForm();
        $model->load($this->request->post());

        if (empty($model->fields)) {
            $model->fields = [];
        }
        if (!in_array('id', (array)$model->fields)) {
            array_unshift($model->fields, 'id');
        }

        if ($this->request->isPost && $model->validate()) {
            //导出数据

            $params = $this->decodeCondition($model->condition);
            $searchModel = new Supplier();
            $dataProvider = $searchModel->search($params ?: []);
            $data = $dataProvider->query->asArray()->select($model->fields)->all();

            $this->export($model->fields, $data);

            return $this->refresh();
        }

        $condition = $this->request->get('condition');
        $model->condition = $condition;

        return $this->render('export-page', [
            'model' => $model,
        ]);
    }

    /**
     * 加密搜索条件
     *
     * @param $params
     *
     * @return string
     */
    private function encodeCondition($params)
    {
        return base64_encode(json_encode($params));
    }

    /**
     * 解密搜索条件
     *
     * @param $encodeParams
     *
     * @return mixed
     */
    private function decodeCondition($encodeParams)
    {
        return json_decode(base64_decode($encodeParams), true);
    }

    /**
     * 导出数据
     *
     * @param $fields
     * @param $data
     */
    private function export($fields, $data)
    {
        set_time_limit(0);
        ini_set('memory_limit', '256M');
        //下载csv的文件名
        $fileName = '导出结果.csv';
        //设置header头
        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        //打开php数据输入缓冲区
        $fp = fopen('php://output', 'a');
        $titles = $fields;
        if ($data) {
            $row = reset($data);
            $titles = array_keys($row);
        }

        //将数据编码转换成GBK格式
        mb_convert_variables('GBK', 'UTF-8', $titles);
        //将数据格式化为CSV格式并写入到output流中
        fputcsv($fp, $titles);

        //如果在csv中输出一个空行，向句柄中写入一个空数组即可实现
        foreach ($data as $row) {
            //将数据编码转换成GBK格式
            $row = array_values($row);
            mb_convert_variables('GBK', 'UTF-8', $row);
            fputcsv($fp, $row);
            //将已经存储到csv中的变量数据销毁，释放内存
            unset($row);
        }
        //关闭句柄
        fclose($fp);
        die;
    }


}

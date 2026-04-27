<?php

namespace app\widgets\views;

use yii\base\Widget;
use app\custom\CustomFunc;

class HistoryWidget extends Widget
{
    public $data;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $maHtml = '<div data-bs-spy="scroll" data-bs-target="#navbar-example3" class="scrollspy-example-2" style="height:400px" data-bs-offset="0" tabindex="0">
        <div class="table-responsive border-top-0">
	       <table class="table  text-nowrap border-0 border-top-0 mb-0 tbl-history">
		      <tbody>';

        if ($this->data != null) {

            foreach ($this->data as $key => $val) {
                $maHtml = $maHtml . '<tr>
                        <td><strong>' . CustomFunc::getShortUserName($val->nguoi_tao) . '</strong> <br/><i>vào lúc</i> <strong><i>' . CustomFunc::convertYMDHISToDMYHI($val->thoi_gian_tao) . '</i></strong></td>
                        <td>' . $val->noi_dung . '</td>
                        </tr>';
            }
        } else {
            $maHtml = 'Không có dữ liệu!';
        }

        $maHtml = $maHtml . '</tbody>
        	</table>
        </div></div>';
        return $maHtml;
    }
}

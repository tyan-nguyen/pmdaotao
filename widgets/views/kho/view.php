
<table>
    <tr>
        <th>Kho</th>
        <td><?= $model->kho ? $model->kho->ten_kho : '' ?></td>
    </tr>
    <tr>
        <th>Kệ</th>
        <td><?= $model->ke ? $model->ke->ten_ke : '' ?></td>
    </tr>
    <tr>
        <th>Ngăn</th>
        <td><?= $model->ngan ? $model->ngan->ten_ngan : '' ?></td>
    </tr>
    <tr>
        <th>Hộp</th>
        <td><?= $model->hop ? $model->hop->ten_hop : '' ?></td>
    </tr>
</table>

<style>
    table {
        width: 50%; 
        margin: left; 
        border-collapse: collapse;
    }
    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
        font-weight: bold;
        width: 30%; 
    }
    td {
        width: 70%; 
    }
</style>

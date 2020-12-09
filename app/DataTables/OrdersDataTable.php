<?php

namespace App\DataTables;

use App\Models\Order;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use DataTables;

class OrdersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTables::eloquent($query)
                        ->editColumn('action', function ($model) {
                            $html = "<a class='confirm-btn btn btn-success'  href='$model->id' >查看</a>";

                            return $html;
                        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('orders-table')
                    ->columns($this->getColumns())
                    ->orderBy(0, 'asc')
                    ->parameters([
                        'pageLength'=> 30, // 客製化長度
                        'language'   => config('datatables.i18n.tw')
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            new Column([
                'title' => '是否運送',
                'data' => 'is_shipped',
                'attributes' => [
                    'data-try' => 'test data',
                ],
            ]),
            Column::make('is_shipped'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::make('user_id'),
            new Column([
                'title' => '功能',
                'data' => 'action',
                'searchable' => false,
            ])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Orders_' . date('YmdHis');
    }
}

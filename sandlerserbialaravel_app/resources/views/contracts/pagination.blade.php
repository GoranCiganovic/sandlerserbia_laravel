<div class="text-center">  
{{ with(new App\Pagination\CustomPresenter($paginator->appends(['contracts'=>$contracts])))->render() }}
</div>
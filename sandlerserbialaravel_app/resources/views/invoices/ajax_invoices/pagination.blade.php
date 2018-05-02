<div class="text-center">  
{{ with(new App\Pagination\CustomPresenter($paginator->appends(['invoices'=>$invoices])))->render() }}
</div> 


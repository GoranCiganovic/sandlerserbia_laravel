<div class="text-center">  
{{ with(new App\Pagination\CustomPresenter($paginator->appends(['proinvoices'=>$proinvoices])))->render() }}
</div> 
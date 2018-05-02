<div class="text-center">  
{{ with(new App\Pagination\CustomPresenter($paginator->appends(['status'=>$status, 'clients'=>$clients, 'legal_filter'=>$legal_filter, 'client_status'=>$client_status, 'sort_filter'=>$sort_filter, 'local_search'=>$local_search])))->render() }}
</div> 
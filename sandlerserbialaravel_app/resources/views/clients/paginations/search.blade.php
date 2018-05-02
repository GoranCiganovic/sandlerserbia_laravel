<div class="text-center">  
{{ with(new App\Pagination\CustomPresenter($paginator->appends(['clients' => $clients, 'search' => $search, 'legal_filter' => $legal_filter,'sort_filter' => $sort_filter])))->render() }}
</div>


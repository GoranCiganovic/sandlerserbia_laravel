<div class="text-center">  
{{ with(new App\Pagination\CustomPresenter($paginator->appends(['participants'=>$participants])))->render() }}
</div> 
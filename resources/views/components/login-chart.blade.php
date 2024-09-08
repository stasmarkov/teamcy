<div
  x-data="{chart: null}"
  x-init=""
>
  <div class="px-4 py-5 bg-white overflow-hidden shadow rounded-lg">
    {!! $chart->container() !!}
    {!! $chart->script() !!}

  </div>
</div>


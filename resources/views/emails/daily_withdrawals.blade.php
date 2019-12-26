<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<br>
<div class="shadow p-3 mb-5 bg-white rounded container">
    <h1 class="text-center text-secondary">Saques Solicitados, {{ $date_formated }}</h1>

    <div class="row card-deck">
        @foreach($withdrawals as $withdraw)
        <div class="col-sm-4">
          <div class="card border-success mb-3">
            <div class="card-body">
                <h5 class="card-title">ID Saque: {{ $withdraw["id_withdraw"] }}</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Valor R$ {{ $withdraw["value"] }}</li>
                    <li class="list-group-item">Taxa R$ {{ $withdraw["fee"] }}</li>
                </ul>
            </div>
          </div>
        </div>
        @endforeach
    </div>

    <div class="row card-deck">
        <div class="col-sm-4">
          <div class="card border-alert mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Saques: R$ {{ $total['withdrawals'] }}</h5>
                <h5 class="card-title">Total Taxas: R$ {{ $total['fees'] }}</h5>
                <h5 class="card-title">Total Deposito R$ {{ $total['withdrawals'] + $total['fees'] }}</h5>
            </div>
          </div>
        </div>
    </div>
</div>
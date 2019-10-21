@extends('layout.master')
@section('content')
    <div class="row">

        <div class="col-md-6 col-md-offset-3">
            <h3>Postavke smjene</h3>
            <p>Treutni nacin rada - Dnevna: 12h radno, 24h neradno, Nocna: 12h radno, 48h neradno</p>
        </div>
        <div class="col-md-6 col-md-offset-3">
            <form action="{{ route('smjena.postavke') }}" method="POST" autocomplete="off">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="form-group">
                        <label for="pocetak" class="control-label {{ $errors->has('pocetak') ? "has-danger" : "" }}">Datum pocetka dnevne smjene</label>
                        <input type="text" class="form-control datetime" id="pocetak" name="pocetak"
                               placeholder="Vaš pocetak"
                               value="{{ old('pocetak') }}">
                        <div class="error">{{$errors->first('pocetak')}}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="vrijeme" class="control-label {{ $errors->has('vrijeme') ? "has-danger" : "" }}">
                            U koliko sati pocinje smjena?
                        </label>
                        <select class="form-control" id="vrijeme" name="vrijeme">
                            <option value="" hidden>Vrijeme pocetka</option>
                            @foreach($times as $key => $time)

                                <option
                                    value="{{ $key }}" {{ old('vrijeme') == $key ? "selected" : ""}}>{{ $time }}</option>
                            @endforeach
                        </select>

                        <div class="error">{{$errors->first('vrijeme')}}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="radio">
                        <label>
                            <input type="radio" name="smjene" id="smjene1" value="1" checked>
                            Izbrisati SVE smjene i spasiti nove
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="smjene" id="smjene2" value="2">
                            Izbrisati smjene nakon izabranog datuma i upisati nove
                        </label>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12" style="text-align:right; margin-top: 10px;">
                        <button type="submit" class="btn btn-success">Izbrisi trenutne i napravi nove</button>

                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('js')
    <script>
        $(function () {
            $('.datetime').datepicker(
                {
                    format: 'dd.mm.yyyy',
                    autoclose: true,
                    todayBtn: true,
                }
            );
            //
            // $(".datetime").datetimepicker({
            //     format: 'dd.mm.yyyy',
            //     autoclose: true,
            //     todayBtn: true,
            // });
        })
    </script>
@endsection

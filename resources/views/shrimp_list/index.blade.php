@include('layouts.header')
<nav class="navbar navbar-expand navbar-dark bg-dark" id="filterbar">
            <form class="form-inline">
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="text-white" for="country">
                                    Filter Lokasi
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <select class="custom-select d-block w-100" id="country" required="">
                                    <option value="">
                                        Pilih Provinsi
                                    </option>
                                    @foreach($provinces as $province)
                                        @if($province->id == $selected_province)
                                        <option selected value="{{$province->id}}">
                                            {{$province->nama}}
                                        </option>
                                        @else
                                        <option value="{{$province->id}}">
                                            {{$province->nama}}
                                        </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select class="custom-select d-block w-100" id="regency" required="" disabled>
                                    <option value="">
                                        Pilih Kabupaten
                                    </option>
                                    @foreach($regions as $region)
                                    <option value="{{$region->id}}">
                                        {{$region->nama}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="text-white" for="sorting">
                                    Urutkan Berdasarkan
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <select class="custom-select d-block w-100" id="sorting" required="" disabled>
                                    <option value="">
                                        Terbaru
                                    </option>
                                    @foreach($sortings as $sorting)
                                    <option value="{{$sorting->id}}">
                                        {{$sorting->nama}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="text-white" for="price">
                                    Urutan Harga
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <select class="custom-select d-block w-100" id="price" required="" disabled>
                                    <option value="">
                                        Acak
                                    </option>
                                    @foreach($prices as $price)
                                    <option value="{{$price->id}}">
                                        {{$price->nama}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <div class="card-title">
                                <strong>
                                    Persebaran Harga Udang
                                </strong>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="map" style="height: 300px; "></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <div class="card-title">
                                <strong>
                                    List Harga Udang
                                </strong>
                                <a class="btn btn-primary btn-sm float-right" href="#">
                                    TAMBAHKAN HARGA BARU
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- list start -->
                            @foreach($lists->price_lists as $list)
                            <div class="card bg-light">
                                <div class="card-body">
                                    <small class="text-muted">
                                        {{$list->created}} / Dibuat oleh petambak / {{$list->creator}}
                                    </small>
                                    <h3 class="text-right">
                                        <small class="text-muted">
                                            {{$list->category}}
                                        </small>
                                    </h3>
                                    <div class="row">
                                        <div class="col-6">
                                            <h3 class="text-muted">
                                                {{$list->province_name}}
                                            </h3>
                                            <div class="h5 text-info">
                                                {{$list->region_name}}
                                            </div>
                                        </div>
                                        <div class="col-6 text-right">
                                                <h6 class="text-muted">
                                                    Harga Ukuran {{$list->size}}:    
                                                </h6>
                                                <div class="h3">
                                                    Rp. {{ number_format($list->price, 0, ',', '.') }}

                                                </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                               Hubungi Penjual:
                                        </div>
                                        <div class="col-4">
                                            {{$list->phone}}
                                            <button class="btn btn-warning btn-sm text-uppercase text-white">
                                                salin
                                            </button>
                                        </div>
                                        <div class="col-8 text-right">
                                            <a href="{{url('shrimp_price', ['id' => $list->id])}}" class="btn btn-primary btn-sm text-uppercase text-white">
                                                lihat semua ukuran
                                            </a>
                                            <button class="btn btn-success btn-sm text-uppercase text-white">
                                                bagikan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            @endforeach
                            <!-- list end -->

                            <textarea hidden id="regions">{{json_encode($lists->regions)}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@include('layouts.footer')
@include('layouts.javascript')

   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA38N74y_xGwSV0bI_36OIXDdH-corZO5A"></script>
    <script>
      var APP_URL = {!! json_encode(url('/')) !!}
      var map;
      // var paths="m -90 -20 v 40 h 170 v -40 h -170 ";
      var regions;
      var markers=[];
      var lat =parseFloat('{{$location->lat}}'),
          lng=parseFloat('{{$location->lng}}');

      $(document).ready(function(){
          regions = JSON.parse($('#regions').val());
          initMap();

          $('#country').change(function(e,obj){
              var id = $(this).val().trim(),
                  text = $("#country option:selected").text().trim();
              if(id.length > 0 && text.length > 0){
                  window.location.href = APP_URL+"?id="+id+"&province_name="+text;
              }
          })
      });

      function initMap() {

          removeMarkers();

        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: lat, lng: lng},
          zoom: 8
        });

        $.each(regions,function(e,obj){

            $.ajax({
                headers: {
                      "accept": "application/json",
                      "Access-Control-Allow-Origin":"*"
                },
                url:'https://maps.googleapis.com/maps/api/geocode/json?address='+obj.name+'&key=AIzaSyA38N74y_xGwSV0bI_36OIXDdH-corZO5A',
                success:function(e){
                    if(e.status == 'OK'){
                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(e.results[0].geometry.location),
                            map: map,
                            icon: {
                              path: "m 100 -20 h -180 v 40 h 180 z l 0 40 m -110 0 c 0 0 0 0 50 0 l -55 15",
                              fillColor: '#0080ff',
                              fillOpacity: .8,
                              strokeWeight: 1,
                              scale: .5,
                              text: "57"
                            },
                            label: "RP. "+obj.average
                        })
                        markers.push(marker);
                    }
                }
            })
        })

      }

      function removeMarkers(){
          $.each(markers,function(e,obj){
            obj.setMap(null)
            })
      }
    </script>

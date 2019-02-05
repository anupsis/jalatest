@include('layouts.header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<nav class="navbar navbar-expand navbar-dark bg-dark" id="filterbar">
            <h5 class="text-white">
                Harga Udang
            </h5>
        </nav>
        <div class="container bg-white">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <div class="card-title">
                                <strong>
                                    Detail Harga Udang
                                </strong>
                                <a class="btn btn-sm btn-info text-uppercase float-right text-white">
                                    semua harga
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="text-primary">
                                        {{$species->name}}
                                    </h5>
                                    {{ date('d-m-Y', strtotime($detail_price->date)) }} <br>
                                    Dibuat oleh petambak <br>
                                    {{$detail_price->contact}}
                                </div>
                                <div class="col-6">
                                    <h5 class="text-primary">
                                        {{$regions->province_name}}
                                    </h5>
                                    <h5 class="text-muted">
                                        {{$regions->regency_name}}
                                    </h5>
                                    Hubungi Penjual: <br>
                                    <button class="btn btn-warning btn-sm text-uppercase text-white">
                                        salin
                                    </button>
                                    0899812312312
                                </div>
                            </div>
                            <br>

                            <table class="table">   
                                <tbody>
                                    <tr>
                                        <td>
                                            Harga Ukuran 120
                                        </td>
                                        <td>
                                            Rp. {{ number_format($detail_price->size_120, 0, ',', '.') }}
                                        </td>
                                    </tr><tr>
                                        <td>
                                            Harga Ukuran 110
                                        </td>
                                        <td>
                                            Rp. {{ number_format($detail_price->size_110, 0, ',', '.') }}
                                        </td>
                                    </tr><tr>
                                        <td>
                                            Harga Ukuran 100
                                        </td>
                                        <td>
                                            Rp. {{ number_format($detail_price->size_100, 0, ',', '.') }}
                                        </td>
                                    </tr><tr>
                                        <td>
                                            Harga Ukuran 90
                                        </td>
                                        <td>
                                            Rp. {{ number_format($detail_price->size_90, 0, ',', '.') }}
                                        </td>
                                    </tr><tr>
                                        <td>
                                            Harga Ukuran 80
                                        </td>
                                        <td>
                                            Rp. {{ number_format($detail_price->size_80, 0, ',', '.') }}
                                        </td>
                                    </tr><tr>
                                        <td>
                                            Harga Ukuran 70
                                        </td>
                                        <td>
                                            Rp. {{ number_format($detail_price->size_70, 0, ',', '.') }}
                                        </td>
                                    </tr><tr>
                                        <td>
                                            Harga Ukuran 60
                                        </td>
                                        <td>
                                            Rp. {{ number_format($detail_price->size_60, 0, ',', '.') }}
                                        </td>
                                    </tr><tr>
                                        <td>
                                            Harga Ukuran 50
                                        </td>
                                        <td>
                                            Rp. {{ number_format($detail_price->size_50, 0, ',', '.') }}
                                        </td>
                                    </tr><tr>
                                        <td>
                                            Harga Ukuran 40
                                        </td>
                                        <td>
                                            Rp. {{ number_format($detail_price->size_40, 0, ',', '.') }}
                                        </td>
                                    </tr><tr>
                                        <td>
                                            Harga Ukuran 30
                                        </td>
                                        <td>
                                            Rp. {{ number_format($detail_price->size_30, 0, ',', '.') }}
                                        </td>
                                    </tr>

                                    
                                    
                                    <tr>
                                        <td>
                                            Catatan
                                        </td>
                                        <td>
                                            Udang dapat dikirin langsung
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-right">
                                <a class="btn text-uppercase btn-sm btn-primary text-white"> ubah </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <a href="#" id="rekomendasi" class="btn btn-light btn-block bg-white"> Rekomendasi </a>
                    <div style="padding-top: 1rem;">
                        <div id="rekomendasi_container" hidden=""></div>
                        <div id="plain_container">
                            @foreach($lists->price_lists as $list)
                            <!-- list start -->
                            <div class="card bg-white">
                                <div class="card-body">
                                    <small class="text-muted">
                                        {{$list->created}} / Dibuat oleh petambak / {{$list->creator}}
                                    </small>
                                    <h3 class="">
                                        <small class="text-muted">
                                            {{$list->category}}
                                        </small>
                                    </h3>
                                    <h6 class="text-muted">
                                        Harga Ukuran {{$list->size}}:     
                                    </h6>
                                    <div class="h3">
                                         Rp. {{ $list->price }}
                                    </div>
                                      
                                    <h3 class="text-muted">
                                        {{$list->province_name}}
                                    </h3>
                                    <div class="h5 text-info">
                                        {{$list->region_name}}
                                    </div>
                               
                                        
                                    <div class="row">
                                        <div class="col-12">
                                               Hubungi Penjual:
                                        </div>
                                        <div class="col-12">
                                            {{$list->phone}}
                                            <button class="btn btn-warning btn-sm text-uppercase text-white">
                                                salin
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            
                                            <a href="{{url('shrimp_price', ['id' => $list->id])}}" class="btn btn-block btn-primary btn-sm text-uppercase text-white">
                                                lihat semua ukuran
                                            </a>
                                            <button class="btn btn-block btn-success btn-sm text-uppercase text-white">
                                                bagikan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <!-- list end -->
                            @endforeach
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
@include('layouts.footer')
@include('layouts.javascript')

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script type="text/javascript">

    var htmls;
    var qwe;
    var APP_URL = {!! json_encode(url('/')) !!};
    var id = {!! $detail_price->province_id !!};
    var options = {
      enableHighAccuracy: true,
    };

    $(document).ready(function(){
        $('#rekomendasi').click(function(){
            navigator.geolocation.getCurrentPosition(success, error, options);
        })
    });

    function success(pos) {
      var crd = {lat: pos.coords.latitude, lng: pos.coords.longitude};
      toastr.info('mencari data rekomendasi');
      $.ajax({
          headers: {
                  "accept": "application/json",
                  "Access-Control-Allow-Origin":"*"
            },
          url:'https://maps.googleapis.com/maps/api/geocode/json?latlng='+crd.lat+','+crd.lng+'&sensor=false&key=AIzaSyA38N74y_xGwSV0bI_36OIXDdH-corZO5A&result_type=administrative_area_level_1',
          success:function(e){
              if(e.status=='OK'){
                var province = e.results[0].address_components[0].long_name;
                var name = province;
                if(province == 'Daerah Khusus Ibukota Jakarta'){
                    name = 'Jakarta';
                }else if(province == 'Special Region of Yogyakarta'){
                    name = 'Yogya';
                }

                $('#rekomendasi_container').html(null);
                $('#rekomendasi_container').removeAttr('hidden');
                $('#plain_container').attr('hidden','hidden');

                $.ajax({
                    headers: {
                          "accept": "application/json",
                          "Access-Control-Allow-Origin":"*"
                    },
                    url:APP_URL+"/rekomendasi/"+name,
                    dataType:'json',
                    success:function(res){
                        if(res.status){
                            toastr.success('Menampilkan rekomendasi');

                            var detail;
                            $.each(res.data.price_lists,function(e,obj){
                                detail = APP_URL+"/shrimp_price/"+obj.id;
                                htmls=card(obj.created, obj.creator, obj.category, obj.category_id, obj.size, obj.price, obj.province_name, obj.region_name, obj.phone, detail);
                                $('#rekomendasi_container').append(htmls);
                            });
                        }
                    },
                    error:function(){
                        toastr.warning('terjadi kesalahan, silakan ulangi lagi');
                    }
                })
              }
          },
          error:function(){
              toastr.warning('terjadi kesalahan, silakan ulangi lagi');
          }
      })
    }

    function error(error) {
      switch (error.code) 
        {
            case error.PERMISSION_DENIED:
                alert("Permission Denied");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("POSITION_UNAVAILABLE");
                break;
            case error.TIMEOUT:
                alert("TIMEOUT");
                break;
            case error.UNKNOWN_ERROR:
                alert("UNKNOWN ERROR");
        }
    }

    function card(date, creator, category, category_id, size, price, province_name, regency_name, phone,url ){
       return '<div class="card bg-white"> <div class="card-body"> <small class="text-muted"> '+date+' / Dibuat oleh petambak / '+creator+'</small> <h3 class=""> <small class="text-muted"> '+category+'</small> </h3> <h6 class="text-muted"> Harga Ukuran '+size+': </h6> <div class="h3"> Rp. '+price+'</div> <h3 class="text-muted"> '+province_name+'</h3> <div class="h5 text-info"> '+regency_name+'</div> <div class="row"> <div class="col-12"> Hubungi Penjual: </div> <div class="col-12"> '+phone+'<button class="btn btn-warning btn-sm text-uppercase text-white"> salin </button> </div> </div> <div class="row"> <div class="col-12"> <a href="'+url+'" class="btn btn-block btn-primary btn-sm text-uppercase text-white"> lihat semua ukuran </a> <button class="btn btn-block btn-success btn-sm text-uppercase text-white"> bagikan </button> </div> </div> </div> </div> <br/>'; 
   }
</script>
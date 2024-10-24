@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pengajuan Pembukaan Rekening</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('applications.store') }}" method="POST">
        @csrf

        <!-- Nama Sesuai KTP -->
        <div class="mb-3">
            <label for="full_name" class="form-label">Nama Sesuai KTP</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
        </div>

        <!-- Tempat Lahir -->
        <div class="mb-3">
            <label for="place_of_birth" class="form-label">Tempat Lahir</label>
            <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth') }}" required>
        </div>

        <!-- Tanggal Lahir -->
        <div class="mb-3">
            <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
        </div>

        <!-- Jenis Kelamin -->
        <div class="mb-3">
            <label for="gender" class="form-label">Jenis Kelamin</label>
            <select class="form-select" id="gender" name="gender" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Wanita" {{ old('gender') == 'Wanita' ? 'selected' : '' }}>Wanita</option>
            </select>
        </div>

        <!-- Pekerjaan -->
        <div class="mb-3">
            <label for="job_id" class="form-label">Pekerjaan</label>
            <select class="form-select" id="job_id" name="job_id" required>
                <option value="">Pilih Pekerjaan</option>
                @foreach($jobs as $job)
                    <option value="{{ $job->id }}" {{ old('job_id') == $job->id ? 'selected' : '' }}>{{ $job->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Alamat -->
        <h4>Alamat</h4>

        <!-- Provinsi -->
        <div class="mb-3">
            <label for="province_id" class="form-label">Provinsi</label>
            <select class="form-select" id="province_id" name="province_id" required>
                <option value="">Pilih Provinsi</option>
                @foreach($provinces as $province)
                    <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Kota/Kabupaten -->
        <div class="mb-3">
            <label for="city_id" class="form-label">Kabupaten/Kota</label>
            <select class="form-select" id="city_id" name="city_id" required>
                <option value="">Pilih Kabupaten/Kota</option>
                @if(old('city_id'))
                    @php
                        $selectedCity = \App\Models\City::find(old('city_id'));
                    @endphp
                    @if($selectedCity)
                        <option value="{{ $selectedCity->id }}" selected>{{ $selectedCity->name }}</option>
                    @endif
                @endif
            </select>
        </div>

        <!-- Kecamatan -->
        <div class="mb-3">
            <label for="district_id" class="form-label">Kecamatan</label>
            <select class="form-select" id="district_id" name="district_id" required>
                <option value="">Pilih Kecamatan</option>
                @if(old('district_id'))
                    @php
                        $selectedDistrict = \App\Models\District::find(old('district_id'));
                    @endphp
                    @if($selectedDistrict)
                        <option value="{{ $selectedDistrict->id }}" selected>{{ $selectedDistrict->name }}</option>
                    @endif
                @endif
            </select>
        </div>

        <!-- Desa/Kelurahan -->
        <div class="mb-3">
            <label for="village_id" class="form-label">Kelurahan</label>
            <select class="form-select" id="village_id" name="village_id" required>
                <option value="">Pilih Kelurahan</option>
                @if(old('village_id'))
                    @php
                        $selectedVillage = \App\Models\Village::find(old('village_id'));
                    @endphp
                    @if($selectedVillage)
                        <option value="{{ $selectedVillage->id }}" selected>{{ $selectedVillage->name }}</option>
                    @endif
                @endif
            </select>
        </div>

        <!-- Nama Jalan -->
        <div class="mb-3">
            <label for="street_name" class="form-label">Nama Jalan</label>
            <input type="text" class="form-control" id="street_name" name="street_name" value="{{ old('street_name') }}" required>
        </div>

        <!-- Nominal Setor -->
        <div class="mb-3">
            <label for="deposit_amount" class="form-label">Nominal Setor (Rupiah)</label>
            <input type="number" class="form-control" id="deposit_amount" name="deposit_amount" value="{{ old('deposit_amount') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Ajukan Pembukaan Rekening</button>
        <a href="{{ route('applications.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        // Fungsi untuk memuat kota berdasarkan provinsi
        $('#province_id').on('change', function(){
            var provinceID = $(this).val();
            if(provinceID){
                $.ajax({
                    type:"GET",
                    url:"{{ url('api/cities') }}/"+provinceID,
                    dataType: 'json',
                    success:function(res){
                        if(res){
                            $("#city_id").empty();
                            $("#city_id").append('<option value="">Pilih Kabupaten/Kota</option>');
                            $.each(res, function(key, value){
                                $("#city_id").append('<option value="'+value.id+'">'+value.name+'</option>');
                            });

                            // Reset kecamatan dan kelurahan
                            $("#district_id").empty();
                            $("#district_id").append('<option value="">Pilih Kecamatan</option>');
                            $("#village_id").empty();
                            $("#village_id").append('<option value="">Pilih Kelurahan</option>');
                        }else{
                            $("#city_id").empty();
                        }
                    }
                });
            }else{
                $("#city_id").empty();
                $("#city_id").append('<option value="">Pilih Kabupaten/Kota</option>');
                $("#district_id").empty();
                $("#district_id").append('<option value="">Pilih Kecamatan</option>');
                $("#village_id").empty();
                $("#village_id").append('<option value="">Pilih Kelurahan</option>');
            }
        });

        // Fungsi untuk memuat kecamatan berdasarkan kota
        $('#city_id').on('change', function(){
            var cityID = $(this).val();
            if(cityID){
                $.ajax({
                    type:"GET",
                    url:"{{ url('api/districts') }}/"+cityID,
                    dataType: 'json',
                    success:function(res){
                        if(res){
                            $("#district_id").empty();
                            $("#district_id").append('<option value="">Pilih Kecamatan</option>');
                            $.each(res, function(key, value){
                                $("#district_id").append('<option value="'+value.id+'">'+value.name+'</option>');
                            });

                            // Reset kelurahan
                            $("#village_id").empty();
                            $("#village_id").append('<option value="">Pilih Kelurahan</option>');
                        }else{
                            $("#district_id").empty();
                        }
                    }
                });
            }else{
                $("#district_id").empty();
                $("#district_id").append('<option value="">Pilih Kecamatan</option>');
                $("#village_id").empty();
                $("#village_id").append('<option value="">Pilih Kelurahan</option>');
            }
        });

        // Fungsi untuk memuat desa berdasarkan kecamatan
        $('#district_id').on('change', function(){
            var districtID = $(this).val();
            if(districtID){
                $.ajax({
                    type:"GET",
                    url:"{{ url('api/villages') }}/"+districtID,
                    dataType: 'json',
                    success:function(res){
                        if(res){
                            $("#village_id").empty();
                            $("#village_id").append('<option value="">Pilih Kelurahan</option>');
                            $.each(res, function(key, value){
                                $("#village_id").append('<option value="'+value.id+'">'+value.name+'</option>');
                            });
                        }else{
                            $("#village_id").empty();
                        }
                    }
                });
            }else{
                $("#village_id").empty();
                $("#village_id").append('<option value="">Pilih Kelurahan</option>');
            }
        });

        // Jika ada nilai lama (old value), muat dropdown berikutnya
        @if(old('province_id'))
            $('#province_id').trigger('change');

            @if(old('city_id'))
                setTimeout(function(){
                    $('#city_id').val({{ old('city_id') }}).trigger('change');
                }, 500);
            @endif

            @if(old('district_id'))
                setTimeout(function(){
                    $('#district_id').val({{ old('district_id') }}).trigger('change');
                }, 1000);
            @endif

            @if(old('village_id'))
                setTimeout(function(){
                    $('#village_id').val({{ old('village_id') }});
                }, 1500);
            @endif
        @endif
    });
</script>
@endsection

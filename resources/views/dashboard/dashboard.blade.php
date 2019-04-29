@extends('layouts.app-inner')




@section('content')


<div class="row width">


    <div class="col-sm text-center">
  

      <span class="bodovi">{{ $data['currentPoints'] }}</span>

    </div>


    <div class="col-sm text-center">


        <button class="btn blue-full-1" type="submit">IZRADI KARTICU</button>

 
    </div>

     <div class="col-sm text-center">

      <div class="anketa">

              <h3>Čistoća poslovnica</h3>

              <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                    <input type="radio" id="poslovnice5" name="poslovnice" value="5" /><label for="poslovnice5" title="5 star"></label>
                    <input type="radio" id="poslovnice4" name="poslovnice" value="4" /><label for="poslovnice4" title="4 star"></label>
                    <input type="radio" id="poslovnice3" name="poslovnice" value="3" /><label for="poslovnice3" title="3 star"></label>
                    <input type="radio" id="poslovnice2" name="poslovnice" value="2" /><label for="poslovnicer2" title="2 star"></label>
                    <input type="radio" id="poslovnice1" name="poslovnice" value="1" /><label for="poslovnice1" title="1 star"></label>
              </div>


             <h3>Prodajno osoblje</h3>

                <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                    <input type="radio" id="osoblje5" name="osoblje" value="5" /><label for="osoblje5" title="5 star"></label>
                    <input type="radio" id="osoblje4" name="osoblje" value="4" /><label for="osoblje4" title="4 star"></label>
                    <input type="radio" id="osoblje3" name="osoblje" value="3" /><label for="osoblje3" title="3 star"></label>
                    <input type="radio" id="osoblje2" name="osoblje" value="2" /><label for="osoblje2" title="2 star"></label>
                    <input type="radio" id="osoblje1" name="osoblje" value="1" /><label for="osoblje1" title="1 star"></label>
                 </div>


              <h3>Asortiman</h3>

                 <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                    <input type="radio" id="asortiman5" name="asortimang" value="5" /><label for="asortiman5" title="5 star"></label>
                    <input type="radio" id="asortiman4" name="asortimang" value="4" /><label for="asortimanr4" title="4 star"></label>
                    <input type="radio" id="asortiman3" name="asortiman" value="3" /><label for="asortiman3" title="3 star"></label>
                    <input type="radio" id="asortiman2" name="asortiman" value="2" /><label for="asortiman2" title="2 star"></label>
                    <input type="radio" id="asortiman1" name="asortiman" value="1" /><label for="asortiman1" title="1 star"></label>
                 </div>
 

                <h3>Dodatno pitanje</h3>

                    <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                        <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="5 star"></label>
                        <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 star"></label>
                        <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 star"></label>
                        <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 star"></label>
                        <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star"></label>
                    </div>

        <!--  <button class="btn blue-ocijeni " type="submit" >OCIJENI</button> -->

            <button class="btn blue-poslano " type="submit" >POSLANO</button>

         <!-- <button class="btn blue-ocijeni " type="submit" disabled>OCIJENI</button> -->

    </div>

 
    </div>
  
  </div>


  <!--old -->
<!--
    <div class="album py-3">
        <div class="row">
            <div class="col-md-8">
                <h1>Trenutni bodovi: {{ $data['currentPoints'] }}</h1>
            </div>
            <div class="col-md-4 text-right">
                <form action="{{ route('logout') }}" method="get">
                    <button type="submit" class="btn btn-outline-danger btn-lg">Odjavi se</button>
                </form>
            </div>
        </div>
    </div>

    @if ( ! $data['required_user_data'])
        <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#requiredModal">
            Popuni podatke o sebi da možeš koristiti Loyalty
        </button>
    @else
        <button type="button" class="btn btn-secondary btn-lg btn-block" data-toggle="modal" data-target="#requiredModal">
            Izmjeni svoje podatke
        </button>
    @endif

    @if ( ! $data['optional_user_data'])
        <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#optionalModal">
            Popuni dodatne podatke i osvoji bodove
        </button>
    @endif

    <hr class="my-4">

    //@include('dashboard.requiredModal', ['user' => $user])
    //@include('dashboard.optionalModal', ['user' => $user])

    <div class="row"></div>

-->
@stop
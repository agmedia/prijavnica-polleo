@extends('layouts.app-inner')

@section('content')

    <div class="row width">

        <div class="col-sm text-center">
            <span class="bodovi">{{ $data['currentPoints'] }}</span>

            @if ( ! $data['required_user_data'])
                <button type="button" class="btn blue-full-1">{{ __('dashboard.required_user_data_fill') }}</button>
            @else
                <button type="button" class="btn blue-full-1">{{ __('dashboard.required_user_data_edit') }}</button>
            @endif

            @if ( ! $data['optional_user_data'])
                <button type="button" class="btn blue-full-1">{{ __('dashboard.optional_user_data') }}</button>
            @endif

        </div>

        <div class="col-sm text-center">
            <button class="btn blue-full-1" type="button" @click="CardOut()">{{ __('dashboard.make_card') }}</button>
        </div>

        <div class="col-sm text-center">
            <div class="anketa">
                <h3>{{ __('dashboard.shop_clean') }}</h3>

                <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                    <input type="radio" id="poslovnice5" name="poslovnice" value="5"/><label for="poslovnice5" title="5 star"></label>
                    <input type="radio" id="poslovnice4" name="poslovnice" value="4"/><label for="poslovnice4" title="4 star"></label>
                    <input type="radio" id="poslovnice3" name="poslovnice" value="3"/><label for="poslovnice3" title="3 star"></label>
                    <input type="radio" id="poslovnice2" name="poslovnice" value="2"/><label for="poslovnice2" title="2 star"></label>
                    <input type="radio" id="poslovnice1" name="poslovnice" value="1"/><label for="poslovnice1" title="1 star"></label>
                </div>

                <h3>{{ __('dashboard.staff') }}</h3>

                <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                    <input type="radio" id="osoblje5" name="osoblje" value="5"/><label for="osoblje5" title="5 star"></label>
                    <input type="radio" id="osoblje4" name="osoblje" value="4"/><label for="osoblje4" title="4 star"></label>
                    <input type="radio" id="osoblje3" name="osoblje" value="3"/><label for="osoblje3" title="3 star"></label>
                    <input type="radio" id="osoblje2" name="osoblje" value="2"/><label for="osoblje2" title="2 star"></label>
                    <input type="radio" id="osoblje1" name="osoblje" value="1"/><label for="osoblje1" title="1 star"></label>
                </div>

                <h3>{{ __('dashboard.asortiment') }}</h3>

                <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                    <input type="radio" id="asortiman5" name="asortiman" value="5"/><label for="asortiman5" title="5 star"></label>
                    <input type="radio" id="asortiman4" name="asortiman" value="4"/><label for="asortiman4" title="4 star"></label>
                    <input type="radio" id="asortiman3" name="asortiman" value="3"/><label for="asortiman3" title="3 star"></label>
                    <input type="radio" id="asortiman2" name="asortiman" value="2"/><label for="asortiman2" title="2 star"></label>
                    <input type="radio" id="asortiman1" name="asortiman" value="1"/><label for="asortiman1" title="1 star"></label>
                </div>

                <h3>{{ __('dashboard.additional_question') }}</h3>

                <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                    <input type="radio" id="star5" name="rating" value="5"/><label for="star5" title="5 star"></label>
                    <input type="radio" id="star4" name="rating" value="4"/><label for="star4" title="4 star"></label>
                    <input type="radio" id="star3" name="rating" value="3"/><label for="star3" title="3 star"></label>
                    <input type="radio" id="star2" name="rating" value="2"/><label for="star2" title="2 star"></label>
                    <input type="radio" id="star1" name="rating" value="1"/><label for="star1" title="1 star"></label>
                </div>

                <button class="btn blue-poslano" type="submit">{{ __('dashboard.btn_send') }}</button>
            </div>
        </div>

    </div>

@stop

@extends("layout")
@section("content")
	@if (Auth::user()->level=="admin" || Auth::user()->level=="staff")
      	
        <?php
            $coordinators = \App\User::where('level','!=','user')->orderBy('first')->get();
            //var_dump($coordinators);

            $coord_array = array();
            foreach ($coordinators as $coordinator)
            {
                $coord_array[$coordinator->id] = $coordinator->first . ' ' . $coordinator->last;
            }

            $mailedFrom_array = [   "1" => "Batavia Post Office 500 N Randall Rd, Batavia, IL 60510",
                                    "2" => "Channahon Post Office 25150 W Channon Dr, Channahon, IL 60410",
                                    "3" => "Joliet Post Office 2000 McDonough St, Joliet, IL 60436",
                                    "4" => "Naperville Post Office 1750 W Ogden Ave, Naperville, IL 60540",
                                    "5" => "Oak Park Post Office 901 Lake St, Oak Park, IL 60301",
                                    "6" => "St Charles Post Office 2600 Oak St, St. Charles, IL 60174",
                                    "7" => "Wheaton Post Office 122 N Wheaton Ave, Wheaton, IL 60187"
            ];

            //var_dump($coord_array);
        ?>
        
        <div class="row">
          <div class="col-lg-6 col-lg-offset-3">
          <h1>Create Session</h1>
            <div class="well bs-component">
        
        {!! Form::open(array('url' => 'createSession', 'class' => 'form-horizontal')) !!}
        <fieldset>
        
        <p>
            {!! Form::label('coord', 'Coordinator') !!}
            {!! Form::select('coord', $coord_array, null, array('class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('site', 'Site') !!}
            {!! Form::select('site', array('DuPage County' => 'DuPage County', 'Kane County' => 'Kane County', 'Cook County' => 'Cook County', 'Will County' => 'Will County', 'Kendall County' => 'Kendall County', 'DeKalb County' => 'Dekalb County', 'Wayside Cross' => 'Wayside Cross'), null, array('class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('date', 'Date') !!}
            {!! Form::date('date', Input::old('date'), array('placeholder' => 'Date', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('mothers', 'Mothers') !!}
            {!! Form::number('mothers', Input::old('mothers'), array('placeholder' => 'Mothers', 'class' => 'form-control')) !!}
        </p>
       
        <p>
            {!! Form::label('fathers', 'Fathers') !!}
            {!! Form::number('fathers', Input::old('fathers'), array('placeholder' => 'Fathers', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('packages', 'Packages') !!}
            {!! Form::number('packages', Input::old('packages'), array('placeholder' => 'Packages', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('volunteers', 'Volunteers') !!}
            {!! Form::number('volunteers', Input::old('volunteers'), array('placeholder' => 'Volunteers', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('hours', 'Hours') !!}
            {!! Form::number('hours', Input::old('hours'), array('placeholder' => 'Hours', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('delivery', 'CD or Website Delivery') !!}
            {!! Form::select('delivery', array('website' => 'Website','cd' => 'CD') , 'website', array('class' => 'form-control')) !!}
        </p>

        <p>
            {!! Form::label('mailedFrom', 'Address you will mail packages from') !!}
            {!! Form::select('mailedFrom', $mailedFrom_array, null, array('class' => 'form-control')) !!}
        </p>

        <p>
            {!! Form::label('postageDate', 'Postage Date') !!}
            {!! Form::date('postageDate', Input::old('postageDate'), array('placeholder' => 'Postage Date', 'class' => 'form-control')) !!}
        </p>

        <p>{!! Form::submit('Submit', array('class' => 'btn btn-primary')) !!}</p>
        </fieldset>
        {!! Form::close() !!}
</div>
</div>
</div>

    @else
    	<p>Insufficent Permissions</p>
    @endif
    
@stop
@extends("layout")
@section("content")
	   
    <?php
       

    ?>



    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
        <h1>Choose shipping type:</h1>
            <div class="well bs-component">
        
                <?php
                    foreach ($shipment->rates as $rate) {
                      if($rate->service == "First")
                      {
                        echo "<h2>";
                        print("First Class: $" . $rate->rate);
                        echo Form::open(array('url' => 'finishPostage'));
                        echo Form::hidden('rateID', $rate->id);
                        echo '<td>' . Form::submit('Order First Class', array('class' => 'btn btn-primary')) .  '</td>';
                        echo Form::close();
                        echo "</h2>";
                      }
                      if($rate->service == "MediaMail")
                      {
                        echo "<h2>";
                        print("MediaMail: $" . $rate->rate);
                        echo Form::open(array('url' => 'finishPostage'));
                        echo Form::hidden('rateID', $rate->id);
                        echo '<td>' . Form::submit('Order MediaMail', array('class' => 'btn btn-primary')) .  '</td>';
                        echo Form::close();
                        echo "</h2>";
                      }

                      //print("carrier");
                      //var_dump($rate->carrier);
                      //var_dump($rate->service);
                      //var_dump($rate->rate);
                      //var_dump($rate->id);
                    }
                ?>

            </div>
        </div>
    </div>
    
@stop
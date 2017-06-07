<ul class="timeline">
      <!-- timeline time label -->
      <li class="time-label">
        <span class="bg-green">
          {{ date('d M. Y', strtotime($ticket->entered_date))}}
        </span>
      </li>
      <!-- /.timeline-label -->
      <!-- timeline item -->
      <li>
        <i class="fa fa-envelope bg-blue"></i>
        <div class="timeline-item">
          <span class="time"><i class="fa fa-clock-o"></i>  {{ date('h:i A', strtotime($ticket->entered_time))}}</span>
          <h3 class="timeline-header"><a href="#">@if($ticket->customer)
               {{ $ticket->customer->name }}
                @elseif($ticket->email)
                 {{ $ticket->sender_name }}@endif</a> sent an email</h3>
          <div class="timeline-body">
            <?php echo urldecode($ticket->body);?>
           </div>

            <div class="timeline-footer">
            <a class="btn btn-primary btn-xs">Read more</a>
            <a class="btn btn-danger btn-xs">Delete</a>
          </div>
        </div>
      </li>

      @if(count($ticket->attachments)!=0)
      <li>
        <i class="fa fa-paperclip bg-blue"></i>
        <div class="timeline-item">
         
          <h3 class="timeline-header"><a href="#">Attachments</a></h3>
          <div class="timeline-body">
            @foreach($ticket->attachments as $attachment)
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 ff"> 
              @if(basename($attachment->type)=='pdf')
              <img class="img-responsive margin" src="{{url('/')."/img/pdf.jpg"}}" />
                  <div class="overlay" style="display:none">
                    <a class="btn btn-md btn-primary iframe" href="{{url('/')."/attachments/$attachment->name"}}">
                      <i class="fa fa-eye"></i>
                    </a>
                  </div>
              @else
                <img class="img-responsive margin" src="{{url('/')."/attachments/$attachment->name"}}" />
                  <div class="overlay" style="display:none">
                    <a class="btn btn-md btn-primary fancybox" href="{{url('/')."/attachments/$attachment->name"}}">
                      <i class="fa fa-eye"></i>
                    </a>
                  </div>
               @endif 
            </div>
              @endforeach
           </div>
           <div class="clearfix"></div>
        </div>
      </li>
      @endif
     
      @foreach($responses as $date => $response_record)
        {{-- //if ticket type is email then compare the ticket received with response created/received date --}}
        @if($date != date('Y-m-d',strtotime($ticket->entered_date)))
          <li class="time-label">
            <span class="bg-green">
              {{ date('d M. Y', strtotime($date))}}
            </span>
          </li>
        @endif

        @foreach($response_record as $response)
         @if($response->response_type=='response')
          <li>
            <i class="fa fa-comments bg-yellow"></i>
            <div class="timeline-item">
              <span class="time"><i class="fa fa-clock-o"></i> @if($response->sender_type=='customer')
              {{ date('h:i A', strtotime($response->entered_time))}}
              @else
              {{ date('h:i A', strtotime($response->entered_time))}}
              @endif </span>
              <h3 class="timeline-header"><a href="#">
              @if($response->sender_type=='customer')
                  @if($ticket->customer)
                    {{ $ticket->customer->name }}
                  @elseif($ticket->email)
                    {{ $ticket->sender_name }}
                  @endif
              @else
              
                 {{ $response->responder->f_name.' '.$response->responder->l_name}}

              @endif</a> Responded</h3>
              <div class="timeline-body">
                {!! html_entity_decode($response->body) !!}
              </div>
                <div class="timeline-footer">
            @if($response->sender_type=='customer')
              <a class="btn btn-primary btn-xs " href="javascript:" onclick="add_func('{{$ticket->id}}','reply')"><i class="fa fa-mail-reply"></i> Reply</a>
              <a class="btn btn-primary btn-xs " href="javascript:" onclick="add_func('{{$ticket->id}}','note')"> Add Note</a>
              {{-- <a class="btn btn-danger btn-xs">Delete</a> --}}
            @endif
          </div>
            </div>
          </li> 
          @endif
          @if($response->response_type=='note')
            <li>
              <i class="fa fa-sticky-note bg-blue"></i>
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 
                  {{ date('h:i A', strtotime($response->entered_time))}}
                </span>
                <h3 class="timeline-header"><a href="#">
               
                   {{ $response->responder->f_name.' '.$response->responder->l_name}}

               </a> Added Note</h3>
                <div class="timeline-body">
                  {!! html_entity_decode($response->body) !!}
                </div>
                <div class="timeline-footer">
               
                </div>
              </div>
            </li> 
          @endif      
        @endforeach
       @endforeach
      <li>
        <i class="fa fa-clock-o bg-gray"></i>
      </li>
    </ul>
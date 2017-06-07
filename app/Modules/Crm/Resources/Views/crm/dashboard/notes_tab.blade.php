<div class="PMContainer">
  @foreach($customer->notes as $note)
  <div class="list-group" style="margin: 0px;">
    <div class="list-form-item list-form-item-white">
        <table style="width: 100%">
          <tbody>
            <tr>
            <td style="width: 60%; cursor:pointer;" id="expand-btn-{{$note->id}}" class="notestoggle" data-id="{{$note->id}}" data-target="note-{{$note->id}}">
                <span><i id="icn-{{$note->id}}" class="glyphicon p glyphicon-chevron-right" style="margin-right: 5px;"></i> {{ $note->subject }}</span>
            </td>
            <td style="width: 15%;">
                <div><i class="fa fa-user" style="color: #969696; text-shadow: 1px 1px 1px #ccc; margin-right: 6px;"></i>{{ isset($note->entered_by->f_name)?$note->entered_by->f_name:'' }}</div>
            </td>
            <td style="width: 15%;">
                <span><i class="fa fa-clock-o" style="color: #969696; text-shadow: 1px 1px 1px #ccc; margin-right: 6px;"></i>{{ $note->created_at->diffForHumans() }}</span>
                <span class="glyphicon glyphicon-time ng-hide"></span>
                <span class="password ng-hide"></span>
            </td>
            <td class="rtl">
              @if($note->source == 'Call')
                <span class="fa fa-fw fa-phone pull-right" title="Call" style="margin-left: 15px;"></span>
              @endif
            </td>
          </tr>
        </tbody>
      </table>
    </div>
      <div class="list-form-item" id="note-{{$note->id}}" style="display:none;">
          <div class="row">
            <div class="col-md-12">
            {{ $note->note }}
            </div>
          </div>
      </div>
  </div>
  @endforeach

</div>

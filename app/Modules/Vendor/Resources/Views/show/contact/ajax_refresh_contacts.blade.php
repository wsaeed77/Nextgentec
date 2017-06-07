
 @foreach($vendor->contacts as $contact)
    <tr id="contact_{{$contact->id}}">

    <td>{{$contact->f_name}} {{$contact->l_name}}</td>
    <td>{{$contact->title}} </td>
    <td>{{$contact->email}} </td>
    <td>{{$contact->phone}} </td>
    <td>{{$contact->mobile}} </td>
    <td>{{ date($date_format->key,strtotime($contact->created_at)) }}</td>
           
    <td>
        
            <a class="btn btn-sm btn-primary" href="javascript:;" data-target="#modal-edit-contact" id="modaal" data-id="{{$contact->id}}"  data-toggle="modal"><i class="fa fa-pencil"></i> Edit</a>
            <button data-target="#modal-delete-contact" id="modaal" data-id="{{$contact->id}}" data-toggle="modal"  class="btn btn-danger btn-sm" type="button">
            <i class="fa fa-times-circle"></i>
            Delete
            </button>
        </td>
    </tr>
@endforeach
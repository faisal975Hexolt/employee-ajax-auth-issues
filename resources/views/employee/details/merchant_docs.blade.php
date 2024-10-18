@php




function printElement($document,$documentName)
{

  return array(
       "doc"=>$document,
       "docName"=>$documentName);

}
$documents=$merchant_business_documents->toArray();

$Docuemntlist=(array_map("printElement",$documents,array_keys($documents)));

@endphp
                
                 @foreach($Docuemntlist as $key =>$row)
                 
                     @if($row['doc'])
                      @if(!in_array($row['docName'],array('id','created_date','created_merchant','verified_status','doc_verified_by','updated_date','updated_by')))
                        <tr> 
                                    <td> {{getDocumentName($row['docName'])}}</td>
                                    <td> 
                                        @if(!empty($row['doc']))

                                            <a href="{{url('/')}}/document-verify/download/merchant-document/{{$folder_name}}/{{$row['doc']}}">
                                                <i class="fa fa-file-pdf-o pdficon"></i>
                                                 
                                            </a>
                                            @else
                                               file not present

                                        @endif
                                    </td>
                                    <td></td>
                                    </tr>

                     @endif
                     @endif

                 @endforeach

                
                     
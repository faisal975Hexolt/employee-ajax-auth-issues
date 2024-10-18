              <div class="row">
                  <div class="col-sm-12 text-center" id="generate-api-response">

                  </div>
              </div>

              <div class="row">
                  <div class="col-sm-12">
                      <div class="tab-button {{ count($api_info) > 0 ? 'display-none' : '' }}">
                          <div class="btn btn-primary pull-right btn-sm margin-bottom-lg admin-generate-api"
                              id="generate-api" mid="{{ $merchant_id }}">Generate</div>
                      </div>
                  </div>
              </div>




              <div class="row">
                  <div class="col-sm-12">
                      <table class="table table-bordered">
                          <thead>
                              <tr>
                                  <th>Api Key Id</th>
                                  <th>Created Date</th>
                                  <th>Action</th>
                                  <th>View</th>
                              </tr>
                          </thead>
                          <tbody>
                              @if (!empty($api_info))
                                  @foreach ($api_info as $api)
                                      <tr>
                                          <td>{{ $api->api_key }}</td>
                                          <td>{{ $api->created_date }}</td>
                                          <td><button class="btn btn-primary btn-sm regenerateApiadmin"
                                                  rowid="{{ $api->id }}"
                                                  mid="{{ $api->created_merchant }}">Regenerate Api</button></td>
                                          <td><button class="btn btn-primary btn-sm viewpayinApiadmin"
                                                  rowid="{{ $api->id }}"
                                                  mid="{{ $api->created_merchant }}">View</button></td>
                                      </tr>
                                  @endforeach
                              @else
                                  <tr>
                                      <td colspan="4" class="text-center">No Data Found</td>
                                  </tr>
                              @endif
                          </tbody>
                      </table>
                  </div>
              </div>

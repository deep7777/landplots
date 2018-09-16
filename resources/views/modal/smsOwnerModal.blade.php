<div id="smsOwnerModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content sms-modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">SMS</h4>
      </div>
      <div class="modal-body">
        <form id="frm_sms" data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <div class="form-group col-xs-12">
            <label for="smsName">Name <span class="required">*</span>
            </label>
            <input readonly="readonly" value="" type="text" id="smsName" name="smsName" required="required" class="form-control col-md-7 col-xs-12">
          </div>
          <div class="form-group col-xs-12">
            <label for="smsSiteName">Site Name <span class="required">*</span>
            </label>
            <input readonly="readonly" value="" type="text" id="smsSiteName" name="smsSiteName" required="required" class="form-control col-md-7 col-xs-12">
          </div>
          <div class="form-group col-xs-12">
            <label for="smsPlotNo">Plot No <span class="required">*</span>
            </label>
            <input readonly="readonly" value="" type="text" id="smsPlotNo" name="smsPlotNo" required="required" class="form-control col-md-7 col-xs-12">
          </div>
          <div class="form-group col-xs-12">
            <label for="smsTo">To <span class="required">*</span>
            </label>
            <input readonly="readonly" value="" type="text" id="smsTo" name="smsTo" required="required" class="form-control col-md-7 col-xs-12">
          </div>
          <div class="form-group col-xs-12">
            <label for="smsMessage">Message <span class="required">*</span>
            </label>
            <textarea required="required" rows="5" required name="smsMessage" id="smsMessage" class="form-control"  data-parsley-trigger="keyup"></textarea>
          </div>
          <div class="form-group col-xs-12">
            <div class="text-center">
              (Limit <span id="smsMessageCounter" class="input-counter count red"></span> out of <span class="text-primary">160</span> characters)</span>
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12 text-right">
              <button id="sms-to-owner" type="button" class="btn btn-success">Send</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@include("frontend/partials/header")
<body>
  @include("frontend/partials/menus")
  <div id="contact_msg" class="center" style="display:none;">Contact form successfully submitted.Thank you,We will get back to you soon.</div>     
  <div class="gmap-area">
      <div class="container">
          <div class="row">
              <div class="col-sm-4 map-content">
                    <ul class="row">
                      <li class="">
                        <address>
                            <h5>Office 1</h5>
                            <div>Anand Nagar,</div>
                            <div>Old Toll Booth,</div>
                            <div>Ranjangaon Ganpati Shirur,</div>
                            <div>Pune-412209 </div><br>

                            <div style="color:red">Office:  8956366161/8956266161 </div>
                            <div style="color:red">Phone:  9146028282/9146048282 </div>
                            <div style="color:red">Email: <a style="color:red" href="mailto:vakratundalanddevelopers@gmail.com">vakratundalanddevelopers@gmail.com</a></div>
                        </address>
                      </li>
                    </ul>
              </div>
              <div class="col-sm-4 map-content ">
                    <ul class="row">
                      <li class="">
                        <address>
                            <h5>Office 2</h5>
                            <div>Shop No 1,Tulsi Hotel,</div>
                            <div>Kharadi Bypass,</div>
                            <div>Near Rakshak Hospital,</div>
                            <div>Hadapsar Road</div> <br>
                            <div style="color:red">Office:  8956366161/8956266161 <div>
                            <div style="color:red">Email: <a style="color:red" href="mailto:vakratundalanddevelopers@gmail.com">vakratundalanddevelopers@gmail.com</a></div>
                        </address>
                      </li>
                    </ul>
              </div>
              <div class="col-sm-4"> 
                  <div class="status alert alert-success" style="display: none"></div>
                  <form action="{{url("/sendContactEnquiry")}}" method="POST" id="contact-form" class="contact-form">
                    {{csrf_field()}}  
                    <div class="col-sm-9 col-sm-offset-1">
                          <div class="form-group">
                              <label>Name *</label>
                              <input type="text" name="name" class="form-control" required="">
                          </div>
                          <div class="form-group">
                              <label>Email *</label>
                              <input type="email" name="email" class="form-control" required="">
                          </div>
                          <div class="form-group">
                              <label>Phone</label>
                              <input type="number" name="phone_no" class="form-control">
                          </div> 
                          <div class="form-group">
                              <label>Subject *</label>
                              <input type="text" name="subject" class="form-control" required="">
                          </div>
                          <div class="form-group">
                              <label>Message *</label>
                              <textarea name="message" id="message" required="" class="form-control" rows="1"></textarea>
                          </div>                        
                          <div class="form-group">
                              <button id="contact_us" name="submit" type="submit"  class="btn btn-primary btn-lg" required="required">Submit Message</button>
                          </div>
                      </div>
                  </form> 
              </div><!--/.row-->
          </div>
      </div>
  </div>
  @include("frontend/partials/scripts")

</body>
<script type="text/javascript">
  $("#contactus").addClass("active");
</script>
</html>
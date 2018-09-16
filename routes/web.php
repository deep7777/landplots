<?php
Route::get('/login', 'HomeController@login');
Route::get('/', 'HomeController@index');
Route::get('/projects/{status_id}', 'HomeController@projectStatus');
Route::get('/siteimages/{site_id}', ['uses' => 'HomeController@siteImages']);

Route::post('/validateLogin', ['uses' => 'LoginController@validateLogin']);
Route::get('/exportvisitor', ['uses' => 'ExportController@index']);

Route::get('/logout', 'LogoutController@index');

Route::get('/contactus', 'HomeController@contactUs');
Route::post('/sendContactEnquiry', ['uses' => 'HomeController@sendContactEnquiry']);


Route::group(['middleware' => 'web','prefix' => 'reports'], function () {
  Route::get('/listPlotBooking', ['uses' => 'ReportsController@listPlotBooking']);
  Route::post('/getPlotBookingReport', ['uses' => 'ReportsController@getPlotBookingReport']);
  Route::get('/listPlotPayments', ['uses' => 'ReportsController@listPlotPayments']);
  Route::post('/getPlotPaymentsReport', ['uses' => 'ReportsController@getPlotPaymentsReport']);
  Route::get('/listExpenses', ['uses' => 'ReportsController@listExpenses']);
  Route::post('/getExpensesReport', ['uses' => 'ReportsController@getExpensesReport']);
  Route::get('/listEmployeeSalary', ['uses' => 'ReportsController@listEmployeeSalary']);
  Route::post('/getEmployeeSalaryReport', ['uses' => 'ReportsController@getEmployeeSalaryReport']);
  Route::post('/getSiteVendors', ['uses' => 'ReportsController@getSiteVendors']);
  Route::get('/listSiteExpense', ['uses' => 'ReportsController@listSiteExpense']);
  Route::post('/getSiteExpenseReport', ['uses' => 'ReportsController@getSiteExpenseReport']);
  Route::get('/listCompanyExpense', ['uses' => 'ReportsController@listCompanyExpense']);
  Route::post('/getCompanyExpenseReport', ['uses' => 'ReportsController@getCompanyExpenseReport']);
  Route::get('/listPaymentReminders', ['uses' => 'ReportsController@listPaymentReminders']);
  Route::post('/getPaymentRemindersReport', ['uses' => 'ReportsController@getPaymentRemindersReport']);
});

Route::group(['middleware' => 'web','prefix' => 'staff'], function () {
  Route::get('/profile', ['uses' => 'StaffController@getStaffProfile']);
  Route::post('/updateProfile', ['uses' => 'StaffController@updateProfile']);
});

Route::group(['middleware' => 'web','prefix' => 'admin'], function () {
  Route::get('/listStaff', ['uses' => 'AdminController@listStaff']);
  Route::get('/addStaff', ['uses' => 'AdminController@addStaff']);
  Route::get('/{staff}/editStaff', ['uses' => 'AdminController@editStaff']);
  Route::get('/profile', ['uses' => 'AdminController@getAdminProfile']);
  Route::post('/createStaff', ['uses' => 'AdminController@createStaff']);
  Route::post('/updateStaff', ['uses' => 'AdminController@updateStaff']);
  Route::post('/deleteStaff', ['uses' => 'AdminController@deleteStaff']);
  Route::post('/updateProfile', ['uses' => 'AdminController@updateProfile']);
  /***************************Company****************************************/
  Route::get('/listCompany', ['uses' => 'CompanyController@listCompany']);
  Route::get('/addCompany', ['uses' => 'CompanyController@addCompany']);
  Route::get('/{compnay}/editCompany', ['uses' => 'CompanyController@editCompany']);
  Route::get('/companyLogo', ['uses' =>'CompanyController@companyLogo']);
  Route::post('/updateCompany', ['uses' => 'CompanyController@updateCompany']);
  Route::post('/createCompany', ['uses' => 'CompanyController@createCompany']);
  Route::post('/uploadCompanyLogo', ['uses' => 'CompanyController@uploadCompanyLogo']);
  /*************************************************************************/

});

/****************************Start Site*************************************/  
Route::get('/addSite', ['uses' => 'SiteController@addSite']);
Route::get('/listSite', ['uses' => 'SiteController@listSite']);
Route::get('/siteLayout/{site_id}', ['uses' => 'SiteController@siteLayout']);
Route::get('/listSiteImages', ['uses' => 'SiteController@listSiteImages']);
Route::get('/addSiteImage', ['uses' => 'SiteController@addSiteImage']);
Route::get('/addSiteImage/{site_id}', ['uses' => 'SiteController@addSiteImage']);
Route::get('/{site}/editSite', ['uses' => 'SiteController@editSite']);
Route::get('/getSiteSoldPlotsStats', ['uses' => 'SiteController@getSiteSoldPlotsStats']);
Route::post('/createSite', ['uses' => 'SiteController@createSite']);
Route::post('/updateSite', ['uses' => 'SiteController@updateSite']);
Route::post('/deleteSite', ['uses' => 'SiteController@deleteSite']);

Route::post('/uploadSiteImage', ['uses' => 'SiteController@uploadSiteImage']);
Route::post('/deleteSiteImage', ['uses' => 'SiteController@deleteSiteImage']);
Route::post('/setSiteImageActive', ['uses' => 'SiteController@setSiteImageActive']);
/****************************End Site*************************************/

/****************************Start Plot*************************************/ 
Route::get('/site/{site_id}/getPlots', ['uses' => 'PlotController@getPlots']);
Route::get('/addSitePlot/{site_id}', ['uses' => 'PlotController@addSitePlot']);
Route::get('/addPlot', ['uses' => 'PlotController@addPlot']);
Route::get('/listPlot', ['uses' => 'PlotController@listPlot']);
Route::get('/sitePlots/{site_id}', ['uses' => 'PlotController@sitePlots']);
Route::get('/bookPlot/{site_id}', ['uses' => 'PlotController@selectPlot']);
Route::get('/editBookedPlot/{booking_id}', ['uses' => 'PlotController@editBookedPlot']);
Route::get('/plotPayment/{booking_id}', ['uses' => 'PlotController@plotPayment']);
Route::get('/listPlotBooking', ['uses' => 'PlotController@listPlotBooking']);
Route::get('/{site}/editPlot', ['uses' => 'PlotController@editPlot']);
Route::get('/plotBookingEmi/{booking_id}', ['uses' => 'PlotBookingController@plotBookingEmi']);

Route::post('/updateBookedPlot', ['uses' => 'PlotController@updateBookedPlot']);
Route::post('/salePlot', ['uses' => 'PlotController@salePlot']);
Route::post('/allocatePlot', ['uses' => 'PlotController@allocatePlot']);
Route::post('/deleteBookingPlot', ['uses' => 'PlotBookingController@deleteBookingPlot']);
Route::post('/deletePlotPayment', ['uses' => 'PlotBookingController@deletePlotPayment']);
Route::post('/getPlotArea', ['uses' => 'PlotController@getPlotArea']);

Route::post('/plots/getPlotCost', ['uses' => 'PlotController@getPlotCost']);
Route::post('/plots/getDownPaymentAmount', ['uses' => 'PlotController@getDownPaymentAmount']);
Route::post('/plots/getPaymentmode', ['uses' => 'PlotController@getPaymentmode']);
Route::post('/createPlot', ['uses' => 'PlotController@createPlot']);
Route::post('/updatePlot', ['uses' => 'PlotController@updatePlot']);
Route::post('/deletePlot', ['uses' => 'PlotController@deletePlot']);
Route::post('/updateBookedPlotPayment', ['uses' => 'PlotController@updateBookedPlotPayment']);
Route::post('/plots/getEmiInstallments',['uses' => 'PlotController@getEmiInstallments']);
Route::post('/setEmi',['uses' => 'PlotBookingController@setEmi']);


Route::post('/plots/getBookingEmiInstallments',['uses' => 'PlotController@getBookingEmiInstallments']);
Route::post('/updateEmiStatus', ['uses' => 'PlotController@updateEmiStatus']);
Route::post('/getBookingInvoice', ['uses' => 'PlotController@getBookingInvoice']);

/****************************End Plot*************************************/

/****************************Start Visitor*************************************/ 
Route::get('/getVisitorInfo/{visitor_id}', ['uses' => 'VisitorController@getVisitorInfo']);
Route::get('/addVisitor', ['uses' => 'VisitorController@addVisitor']);
Route::get('/listVisitor', ['uses' => 'VisitorController@listVisitor']);
Route::get('/{visitor}/editVisitor', ['uses' => 'VisitorController@editVisitor']);
Route::get('/siteVisitor/{site_id}', ['uses' => 'VisitorController@siteVisitor']);
Route::post('/createVisitor', ['uses' => 'VisitorController@createVisitor']);
Route::post('/updateVisitor', ['uses' => 'VisitorController@updateVisitor']);
Route::post('/deleteVisitor', ['uses' => 'VisitorController@deleteVisitor']);
/****************************End Visitor*************************************/ 

/****************************Start Contractor**********************************/  
Route::get('/addContractor', ['uses' => 'ContractorController@addContractor']);
Route::get('/listContractor', ['uses' => 'ContractorController@listContractor']);
Route::get('/{contractor_id}/editContractor', ['uses' => 'ContractorController@editContractor']);
Route::post('/createContractor', ['uses' => 'ContractorController@createContractor']);
Route::post('/updateContractor', ['uses' => 'ContractorController@updateContractor']);
Route::post('/deleteContractor', ['uses' => 'ContractorController@deleteContractor']);

/////////////////////////////Contractor Customer ///////////////////////////////
Route::get('/addContractorCustomer', ['uses' => 'ContractorController@addContractorCustomer']);
Route::get('/listContractorCustomer', ['uses' => 'ContractorController@listContractorCustomer']);
Route::get('/{contractor_customer_id}/editContractorCustomer', ['uses' => 'ContractorController@editContractorCustomer']);
Route::get('/siteContractorCustomer/{contractor_customer_id}', ['uses' => 'ContractorController@siteContractorCustomer']);
Route::post('/createContractorCustomer', ['uses' => 'ContractorController@createContractorCustomer']);
Route::post('/updateContractorCustomer', ['uses' => 'ContractorController@updateContractorCustomer']);
Route::post('/deleteContractorCustomer', ['uses' => 'ContractorController@deleteContractorCustomer']);
/////////////////////////////End Contractor Customer ///////////////////////////////

/****************************End Contractor************************************/

/****************************Start Site Partners**********************************/
Route::get('/listPartners', ['uses' => 'SitePartnersController@listPartners']);
Route::get('/addPartner/{site_id}', ['uses' => 'SitePartnersController@addPartner']);
Route::post('/delSitePartner', ['uses' => 'SitePartnersController@delSitePartner']);
Route::post('/addSitePartner', ['uses' => 'SitePartnersController@addSitePartner']);
Route::get('/editSitePartner/{partner_id}', ['uses' => 'SitePartnersController@editSitePartner']);
Route::post('/updateSitePartner', ['uses' => 'SitePartnersController@updateSitePartner']);
Route::post('/getPartnerPercentage', ['uses' => 'SitePartnersController@getPartnerPercentage']);
Route::post('/getPartnerAmount', ['uses' => 'SitePartnersController@getPartnerAmount']);
Route::get('/partnerPayment/{partner_id}', ['uses' => 'SitePartnersController@partnerPayment']);
Route::post('/partner/getPaymentmode', ['uses' => 'SitePartnersController@getPaymentmode']);
Route::post('/updatePartnerPayment', ['uses' => 'SitePartnersController@updatePartnerPayment']);

/****************************End Site Partners**********************************/ 

/****************************Start Purchase Order******************************/
Route::get('/listPurchaseOrder', ['uses' => 'PurchaseOrderController@listPurchaseOrder']);
Route::get('/addPurchaseOrder/{site_id}', ['uses' => 'PurchaseOrderController@addPurchaseOrder']);
Route::get('/editPurchaseOrder/{site_id}', ['uses' => 'PurchaseOrderController@editPurchaseOrder']);
Route::get('/deletePurchaseOrder', ['uses' => 'PurchaseOrderController@editPurchaseOrder']);
Route::post('/createPurchaseOrder', ['uses' => 'PurchaseOrderController@createPurchaseOrder']);
Route::post('/updatePurchaseOrder', ['uses' => 'PurchaseOrderController@updatePurchaseOrder']);
/****************************End Purchase Order********************************/  

/****************************Start Message*************************************/  
Route::get('/listMessage', ['uses' => 'MessageController@listMessage']);
/****************************End Message*************************************/ 


/****************************Dashboard Routes*************************************/ 
Route::get('/admin', 'AdminController@index');
Route::get('/staff', 'StaffController@index');
/****************************Dashboard Routes*************************************/ 

/****************************User Login*************************************/ 
Route::post('/staffLogin', 'LoginController@validateStaff');
Route::post('/adminLogin', 'LoginController@validateAdmin');
/****************************End User Login**********************************/ 

Route::resource('suppliers', 'SupplierController');
Route::resource('purchaseorders', 'PurchaseOrderController');
Route::resource('uoms', 'UomController');
Route::resource('items', 'ItemController');
Route::resource('expenses', 'ExpenseController');
Route::post('getExpensePaymentMode', ['uses' => 'ExpenseController@getPaymentMode']);
Route::resource('siteexpenses', 'SiteExpenseController');
Route::post('getSiteExpensePaymentMode', ['uses' => 'SiteExpenseController@getPaymentMode']);

Route::resource('employees', 'EmployeeController');
Route::resource('salaries', 'SalaryController');

Route::get('/sendEmail', ['uses' => 'EmailController@index']);
Route::get('/plotData', ['uses' => 'PlotBookingController@plotData']);

@extends('layout.settingslayout')
@section('content')

       
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
					<div class="row">
						<div class="col-md-8 offset-md-2">
						
							<!-- Page Header -->
							<div class="page-header">
								<div class="row">
									<div class="col-sm-12">
										<h3 class="page-title">Salary Settings</h3>
									</div>
								</div>
							</div>
							<!-- /Page Header -->
							
							<form method="POST" action="{{ route('addSalarySettings') }}" enctype="multipart/form-data" files="true">
								@csrf
								
								<!-- DA and HRA Settings -->
								<div class="settings-widget">
									<div class="h3 card-title with-switch">
									 Medical Allowance											
										
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>During Probation (%)</label>
												<input type="number" name="probMedicalAllowance" value="{{!empty($salarySettingData->probMedicalAllowance) ? $salarySettingData->probMedicalAllowance: ''}}" class="form-control" placeholder="Please add number value only">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>On Confirmation (%)</label>
												<input type="number" name="medicalAllowance" value="{{!empty($salarySettingData->medicalAllowance) ? $salarySettingData->medicalAllowance: ''}}" class="form-control" placeholder="Please add number value only">
											</div>
										</div>
									</div>
								</div>
								<!-- /DA and HRA Settings -->
								
								<!-- Provident Fund Settings -->
								<div class="settings-widget">
									<div class="h3 card-title with-switch">
										Provident Fund											
										
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>During Probation Employee Share(%)</label>
												<input type="number" name="probPfEmplyee" value="{{!empty($salarySettingData->probPfEmplyee) ? $salarySettingData->probPfEmplyee: ''}}"  class="form-control" placeholder="Please add number value only">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>During Probation Employer's Share(%)</label>
												<input type="number" name="probPfEmployer" value="{{!empty($salarySettingData->probPfEmployer) ? $salarySettingData->probPfEmployer: ''}}" class="form-control" placeholder="Please add number value only">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>On Confirmation Employee Share(%)</label>
												<input type="number" name="pfEmployee" value="{{!empty($salarySettingData->pfEmployee) ? $salarySettingData->pfEmployee: ''}}" class="form-control" placeholder="Please add number value only">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>On Confirmation Employer's Share(%)</label>
												<input type="number" name="pfEmployer" value="{{!empty($salarySettingData->pfEmployer) ? $salarySettingData->pfEmployer: ''}}" class="form-control" placeholder="Please add number value only">
											</div>
										</div>
									</div>
								</div>

								
								<!-- /Provident Fund Settings -->


								<!-- EOIB Settings -->
								<div class="settings-widget">
									<div class="h3 card-title with-switch">
										EOIB											
										
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>During Probation Employee Share</label>
												<input type="number" name="probEobiEmployee" value="{{!empty($salarySettingData->probEobiEmployee) ? $salarySettingData->probEobiEmployee: ''}}" class="form-control" placeholder="Please add number value only">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>During Probation Employer's Share</label>
												<input type="number" name="probEobiEmployer" value="{{!empty($salarySettingData->probEobiEmployer) ? $salarySettingData->probEobiEmployer: ''}}" class="form-control" placeholder="Please add number value only">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>On Confirmation Employee Share</label>
												<input type="number" name="eobiEmployee" value="{{!empty($salarySettingData->eobiEmployee) ? $salarySettingData->eobiEmployee: ''}}" class="form-control" placeholder="Please add number value only">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>On Confirmation Employer's Share</label>
												<input type="number" name="eobiEmployeer" value="{{!empty($salarySettingData->eobiEmployeer) ? $salarySettingData->eobiEmployeer: ''}}" class="form-control" placeholder="Please add number value only">
											</div>
										</div>
									</div>
								</div>

								<input type="hidden" name="id" value="{{!empty($salarySettingData->id) ? $salarySettingData->id: ''}}" class="form-control" placeholder="Please add number value only">

								<!-- /EOIB Settings -->
								
							
								<!-- Submit Button -->
								<div class="submit-section">
									<button class="btn btn-primary submit-btn" type="submit">Save</button>
								</div>
								<!-- /Submit Button -->
								
                            </form>
						</div>
					</div>
                </div>
				<!-- /Page Content -->
				
            </div>
			<!-- /Page Wrapper -->
			</div>
			@endsection
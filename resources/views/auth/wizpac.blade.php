
							
							<!-- Account Form -->


							<form method="POST" action="http://localhost/wizpacv2/public/login" id="wizpac">
								<div style="display: none">
								<input id="email" type="email"  name="email" value="{{ Auth::user()->email }}">
								<input id="text" type="password"  name="password" value="{{ Auth::user()->password }}">
								</div>
								<div class="form-group text-center">
									<button class="btn btn-primary account-btn" type="submit">Login</button>
								</div>
							</form>
							<!-- /Account Form -->

{{-- @include('admin.includes.sidebar-skin') --}}
<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
		  <ul class="nav">
				<!-- <li class="nav-item nav-profile">
				  	<div class="nav-link">
						<div class="profile-name">
						  	
						  	<p class="designation">
						  		@yield('role')
						  	</p>
						</div>
				  	</div>
				</li> -->
				<li class="nav-item">
			  		<a class="nav-link" href="{{url('admin/dashboard')}}">
						<i class="icon-home menu-icon"></i>
						<span class="menu-title">Dashboard</span>
			  		</a>
				</li>
				@if(Auth::user()->is_super==1)
				<li class="nav-item">
				  <a class="nav-link" href="{{url('admin/comission')}}">
					<i class="icon-rocket menu-icon"></i>
					<span class="menu-title">Comission & Charges</span>
				  </a>
				</li>

				<li class="nav-item">
				  	<a class="nav-link" href="{{url('admin/sub-admins')}}">
						<i class="icon-people menu-icon"></i>
						<span class="menu-title">Sub-admin</span> 
				  	</a>
				</li>

				<li class="nav-item">
				  	<a class="nav-link" href="{{url('admin/transactions')}}">
						<i class="fa fa-dollar menu-icon" aria-hidden="true"></i>
						<span class="menu-title">Transactions</span> 
				  	</a>
				</li>

				
				
				<li class="nav-item">
				  	<a class="nav-link" data-toggle="collapse" href="#page-layouts" aria-expanded="false" aria-controls="page-layouts">
						<i class="fa fa-dollar menu-icon"></i>
						<span class="menu-title">Revenue</span>
				  	</a>
				  	<div class="collapse" id="page-layouts">
						<ul class="nav flex-column sub-menu">
					  		<li class="nav-item d-none d-lg-block"> 
					  			<a class="nav-link" href="{{url('admin/revenue-summary')}}">Summary</a>
					  		</li>
						  	<li class="nav-item d-none d-lg-block">
								<a class="nav-link" href="{{url('admin/revenue')}}">All Revenues Listing</a>
						  	</li>
						</ul>
				  	</div>
				</li>
			@endif


			@if(NotificationManager::checkPermission('client_management_access'))
				<li class="nav-item">
				  <a class="nav-link" href="{{url('admin/clients')}}">
					<i class="icon-people menu-icon"></i>
					<span class="menu-title">Clients</span>
				  <span class="badge badge-success">{{ProjectManager::userCount(config('constants.role.CLIENT'))}}</span> 
				  </a>
				</li>
			@endif

			@if(NotificationManager::checkPermission('talent_management_access'))
			<li class="nav-item">
			  <a class="nav-link" href="{{url('admin/talents')}}">
				<i class="icon-people menu-icon"></i>
				<span class="menu-title">Talents</span>
			  <span class="badge badge-success">{{ProjectManager::userCount(config('constants.role.TALENT'))}}</span> 
			  </a>
			</li>
			@endif

			@if(NotificationManager::checkPermission('financial_reports_access'))
				<li class="nav-item">
				  	<a class="nav-link" data-toggle="collapse" href="#report-layouts" aria-expanded="false" aria-controls="report-layouts">
						<i class="fa fa-table menu-icon" aria-hidden="true"></i>

						<span class="menu-title">Reports</span>
				  	</a>
				  	<div class="collapse" id="report-layouts">
						<ul class="nav flex-column sub-menu">
					  		<li class="nav-item d-none d-lg-block"> 
					  			<a class="nav-link" href="{{url('admin/project-wise-summary')}}">Project Wise Summary</a>
					  		</li>
					  		<li class="nav-item d-none d-lg-block"> 
					  			<a class="nav-link" href="{{url('admin/disputed-project-wise-summary')}}">Disputed Project Summary</a>
					  		</li>

					  		<li class="nav-item d-none d-lg-block"> 
					  			<a class="nav-link" href="{{url('admin/terminated-project-wise-summary')}}">Terminated Project Summary</a>
					  		</li>
					  		<li class="nav-item d-none d-lg-block"> 
					  			<a class="nav-link" href="{{url('admin/talent-performance-rating')}}">Talent Performance Rating</a>
					  		</li>
					  		<li class="nav-item d-none d-lg-block"> 
					  			<a class="nav-link" href="{{url('admin/skills-wise-summary')}}">Skills Wise Summary</a>
					  		</li>

					  		<li class="nav-item d-none d-lg-block"> 
					  			<a class="nav-link" href="{{url('admin/revenue-summary')}}">Revenue Summary</a>
					  		</li>

					  		<li class="nav-item d-none d-lg-block"> 
					  			<a class="nav-link" href="{{url('admin/talent-summary')}}">Talent Summary</a>
					  		</li>
					  		<li class="nav-item d-none d-lg-block"> 
					  			<a class="nav-link" href="{{url('admin/client-summary')}}">Client Summary</a>
					  		</li>
					  		<li class="nav-item d-none d-lg-block"> 
					  			<a class="nav-link" href="{{url('admin/profit-summary')}}">Gross Profit</a>
					  		</li>
						</ul>
				  	</div>
				</li>
			@endif

			@if(NotificationManager::checkPermission('talent_management_access') || NotificationManager::checkPermission('client_management_access'))
			<li class="nav-item">
			  <a class="nav-link" href="{{url('admin/wallet-balance')}}">
				<i class="icon-wallet menu-icon"></i>
				<span class="menu-title">Wallet Balance</span>
			  </a>
			</li>
			@endif

		

			@if(NotificationManager::checkPermission('coupon_management_access'))
			<li class="nav-item">
			  <a class="nav-link" href="{{url('admin/coupon')}}">
				<i class="fa fa-gift menu-icon" aria-hidden="true"></i>
				<span class="menu-title">Coupon</span>
			  </a>
			</li>
			@endif

			@if(NotificationManager::checkPermission('projects_management_access'))
			<li class="nav-item">
			  <a class="nav-link" href="{{url('admin/projects')}}">
				<i class="icon-docs menu-icon"></i>
				<span class="menu-title">Project Posted</span>
			  </a>
			</li>
			@endif

			@if(NotificationManager::checkPermission('projects_management_access'))
			<li class="nav-item">
				<a class="nav-link" href="{{url('admin/disputed-projects')}}">
					<i class="icon-docs menu-icon"></i>
					<span class="menu-title">Disputed Project</span>
				</a>
			</li>
			@endif

			@if(NotificationManager::checkPermission('categories_management_access'))
			 <li class="nav-item">
				<a class="nav-link" href="{{url('admin/categories')}}">
					<i class="icon-list menu-icon"></i>
					<span class="menu-title">Categories</span>
				</a>
			</li>
			@endif

			@if(NotificationManager::checkPermission('skills_management_access'))
			 <li class="nav-item">
				<a class="nav-link" href="{{url('admin/skills')}}">
					<i class="icon-list menu-icon"></i>
					<span class="menu-title">Services</span>
				</a>
			</li>
			@endif


			
		   <!--  <li class="nav-item">
				<a class="nav-link" href="{{url('admin/transactions')}}">
					<i class="icon-docs menu-icon"></i>
					<span class="menu-title">All Transactions</span>
				</a>
			</li> -->

			<!--   <li class="nav-item">
			  <a class="nav-link" href="{{url('admin/reviews')}}">
				<i class="icon-question menu-icon"></i>
				<span class="menu-title">Rate & Reviews</span>
			  </a>
			</li> -->

			@if(NotificationManager::checkPermission('rating_management_access'))
				<li class="nav-item">
				  <a class="nav-link" data-toggle="collapse" href="#page-layouts" aria-expanded="false" aria-controls="page-layouts">
					<i class="icon-handbag menu-icon"></i>
					<span class="menu-title">Rate & Reviews</span>
				  </a>
				  <div class="collapse" id="page-layouts">
					<ul class="nav flex-column sub-menu">
					  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('client_reviews')}}">CLient</a>
					  </li>
					  <li class="nav-item d-none d-lg-block">
						<a class="nav-link" href="{{route('talent_reviews')}}">Talent</a>
					  </li>
					</ul>
				  </div>
				</li>
			@endif

			@if(NotificationManager::checkPermission('escalations_management_access'))
			<li class="nav-item">
			  <a class="nav-link" href="{{url('admin/escalations')}}">
				<i class="icon-question menu-icon"></i>
				<span class="menu-title">Escalations</span>
			  </a>
			</li>
			@endif
			
			@if(NotificationManager::checkPermission('faq_management_access'))
			<li class="nav-item">
			  <a class="nav-link" href="{{url('admin/faqs')}}">
				<i class="fa fa-bars menu-icon" aria-hidden="true"></i>

				<span class="menu-title">FAQs</span>
			  </a>
			</li>
			@endif

			@if(NotificationManager::checkPermission('sitecontent_management_access'))
				<li class="nav-item">
					<a class="nav-link" data-toggle="collapse" href="#sitecontent-layouts" aria-expanded="false" aria-controls="sitecontent-layouts">
						<i class="fa fa-file-text-o menu-icon" aria-hidden="true"></i>

						<span class="menu-title">Site Contents</span>
					</a>
					<div class="collapse" id="sitecontent-layouts">
						<ul class="nav flex-column sub-menu">
							<li class="nav-item d-none d-lg-block"> 
								<a class="nav-link" href="{{url('admin/aboutus')}}">About Us</a>
							</li>
							<li class="nav-item d-none d-lg-block">
								<a class="nav-link" href="{{url('admin/contactus')}}">Contact Us</a>
							</li>
							<li class="nav-item d-none d-lg-block">
								<a class="nav-link" href="{{url('admin/privacypolicy')}}">Privacy Policy</a>
							</li>
							<li class="nav-item d-none d-lg-block">
								<a class="nav-link" href="{{url('admin/sitecontent/adb')}}">ADB Content</a>
							</li>
							<li class="nav-item d-none d-lg-block">
								<a class="nav-link" href="{{url('admin/sitecontent/clientterms')}}">Client Terms</a>
							</li>
							<li class="nav-item d-none d-lg-block">
								<a class="nav-link" href="{{url('admin/sitecontent/todderterms')}}">Todder Terms</a>
							</li>
							<li class="nav-item d-none d-lg-block">
								<a class="nav-link" href="{{url('admin/sitecontent/paymentsafety')}}">Payment Safety</a>
							</li>
							<li class="nav-item d-none d-lg-block">
								<a class="nav-link" href="{{url('admin/sitecontent/whyworkwithtalent')}}">Why Work With Talent</a>
							</li>
							<li class="nav-item d-none d-lg-block">
								<a class="nav-link" href="{{url('admin/sitecontent/whyworkwithclient')}}">Why Work With Client</a>
							</li>
						</ul>
					</div>
				</li>
			@endif
			<li class="nav-item">
				<a class="nav-link" data-toggle="collapse" href="#settings-layouts" aria-expanded="false" aria-controls="settings-layouts">
					<i class="fa fa-cogs menu-icon" aria-hidden="true"></i>
					<span class="menu-title">Settings</span>
				</a>
				<div class="collapse" id="settings-layouts">
					<ul class="nav flex-column sub-menu">
						<li class="nav-item d-none d-lg-block"> 
							<a class="nav-link" href="{{url('admin/profile')}}">Profile</a>
						</li>
						@if(Auth::user()->is_super==1)
							<li class="nav-item d-none d-lg-block">
								<a class="nav-link" href="{{url('admin/payment-details')}}">Payment Details</a>
							</li>
						@endif
						<li class="nav-item d-none d-lg-block">
							<a class="nav-link" href="{{url('admin/change-password')}}">Change Password</a>
						</li>
					</ul>
				</div>
			</li>

		  </ul>
		</nav>
		<!-- partial -->
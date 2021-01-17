@extends('web.layouts.app')
@section('title', 'Contact Us')
@section('content')
<section class="contactSection">
    <div class="container">
        <h2>Get in touch</h2>
        <div class="row">
            <div class="col-md-9">
                @if(Session::has('error'))
                    <div class="text-danger mb-3">{{Session::get('error')}}</div>
                @endif
                @if(Session::has('success'))
                    <div class="text-success mb-3">{{Session::get('success')}}</div>
                @endif
                <form name="contact-form" method="post" action="{{route('saveContactUs')}}">
                    @csrf
                    <input type="text" placeholder="Full Name" name="name" required value="{{old('name')}}" autocomplete="off" >
                    @if($errors->has('name'))
                        <p class="text-danger">{{ $errors->first('name') }}</p>
                    @endif
                    <input type="text" placeholder="Email" name="email" required value="{{old('email')}}" autocomplete="off" >
                     @if($errors->has('email'))
                        <p class="text-danger">{{ $errors->first('email') }}</p>
                    @endif
                    <!-- <select type="select" id="" name="purpose" required>
                        <option value="General Questions">General Questions</option>
                        <option value="Sales Inquiries">Sales Inquiries</option>
                        <option value="Help/Support">Help/Support</option>
                        <option value="Partnerships">Partnerships</option>
                        <option value="Press">Press</option>
                        <option value="Other">Other</option>
                    </select>
                    @if($errors->has('purpose'))
                        <p class="text-danger">{{ $errors->first('purpose') }}</p>
                    @endif -->
                    <textarea id="" cols="30" rows="10" name="message" placeholder="I would like to know about...">{{old('message')}}</textarea>
                    @if($errors->has('message'))
                        <p class="text-danger">{{ $errors->first('message') }}</p>
                    @endif
                    <!-- <button type="button" class="sendBtn">Send Message</button> -->
                    <button type="submit" class="theme-button hover-ripple mb-3 sendBtn">Send Message</button>
                </form>
            </div>
            <div class="col-md-3">
                <ul class="contactDetails">
                    <!-- <li>
                        <h3>Sales Inquiries</h3>
                        <p><a href="tel:+18886043188">+1.888.604.3188</a></p>
                    </li> -->
                    <li>
                        <h3>Customer support</h3>
                        <p><a href="mailto:Support@tod-Z.comm">Support@tod-Z.com</a></p>
                    </li>
                   <!--  <li>
                        <h3>Press</h3>
                        <p><a href="mailto:press@tod-Z.com">press@tod-Z.com</a></p>
                    </li>
                    <li>
                        <h3>Partnerships</h3>
                        <p><a href="mailto:partners@tod-Z.com">partners@tod-Z.com</a></p>
                    </li>
                    <li>
                        <h3>Investors</h3>
                        <p><a href="mailto:investors@tod-Z.com">investors@tod-Z.com</a></p>
                    </li>
                    <li>
                        <h3>Delaware Mailing Address</h3>
                        <p><span>Toptal, LLC<br>2810 N. Church St #36879<br>Wilmington, DE
                                19802-4447</span></p>
                    </li>
                    <li>
                        <h3>San Francisco Mailing Address</h3>
                        <p><span>Toptal, LLC<br>548 Market St #36879<br>San Francisco, CA
                                94104</span></p>
                    </li>
                    <li>
                        <h3>New York Mailing Address</h3>
                        <p><span>Toptal, LLC<br>228 Park Ave S #36879<br>New York, NY
                                10003</span></p>
                    </li> -->
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
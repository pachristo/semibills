@extends('welcome')

@section('title')
    Privacy Policy- semibill.com
@endsection
@section('body')
    @include('partial', ['title' => 'Privacy Policy '])


    <!-- App-Solution-Section-Start -->
    <section class="row_am app_solution_section">
        <!-- container start -->
        <div class="container">
            <!-- row start -->
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <!-- UI content -->
                    <div class="app_text">
                        <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                            {{-- <h2><span>Providing innovative app solution</span> to make customer --}}
                            {{-- life easy to grow.</h2> --}}
                        </div>
                        <p>1. Introduction<br />Welcome to Semibill! This Privacy Policy is designed to inform you about how we
                            collect, use, and safeguard your personal information when you use our multifunctional service
                            platform.<br />2. Information We Collect<br />&bull; User-Provided Information: Semibill may
                            collect information that you provide, including [examples like name, email, etc.].<br />&bull;
                            Transaction Information: When you make purchases or transactions on Semibill, we collect relevant
                            information to facilitate and process your requests.<br />&bull; Automatically Collected
                            Information: We automatically collect certain information, such as [examples like device
                            information, IP address, etc.].<br />3. How We Use Your Information<br />We use the collected
                            information for purposes such as [examples like processing transactions, providing personalized
                            services, improving user experience, etc.].<br />4. Sharing Your Information<br />We respect
                            your privacy. Semibill does not sell, trade, or transfer your personal information to third parties
                            without your consent. However, we may share information with trusted third parties for specific
                            purposes, such as [examples like payment processing, hotel booking services, etc.].<br />5.
                            Security<br />Semibill takes the security of your information seriously and implements measures to
                            protect it. However, no method of transmission over the internet or electronic storage is 100%
                            secure.<br />6. Your Choices<br />You have control over the information you provide to us.
                            [Include instructions on how users can update their preferences or delete their Semibill
                            account.]<br />7. Changes to This Privacy Policy<br />We may update this Privacy Policy
                            periodically. Notifications about changes will be provided through [method of notification].
                            Continued use of the Semibill platform after modifications constitutes your acknowledgment of the
                            revised policy.<br />8. Contact Us<br />If you have any questions or concerns about this Privacy
                            Policy, please reach out to us at <a href="mailto:admin@semibill.com">admin@semibill.com</a>.<br />By using Semibill, you agree to
                            the terms outlined in this Privacy Policy.</p>
                    </div>
                </div>

            </div>
            <!-- row end -->
        </div>
        <!-- container end -->
    </section>
    <!-- App-Solution-Section-end -->
@endsection

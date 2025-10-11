@extends('layouts.authenticated')

@section('title', 'About Me - Alexander Perry')
@section('page-title', 'About Me')

@section('content')
<div class="resume-container">
    <div class="resume-header">
        <h1 class="resume-name">ALEXANDER PERRY</h1>
        <p class="resume-title">Lead Software Engineer | Engineering Director | Product Leader</p>
        <p class="resume-contact">
            📍 Rochester, NY &nbsp;|&nbsp; 
            📞 <span class="contact-phone" title="Click to reveal phone number">
                <span class="reveal-trigger" data-type="phone">Click to show phone</span>
                <span class="contact-hidden" style="display:none;"></span>
            </span> &nbsp;|&nbsp; 
            ✉️ <span class="contact-email contact-link" title="Click to reveal email">
                <span class="reveal-trigger" data-type="email">Click to show email</span>
                <span class="contact-hidden" style="display:none;"></span>
            </span>
        </p>
        <div style="position:absolute;left:-9999px;" aria-hidden="true">
            <span>fakeemail@scraperbait.com</span>
            <span>(000) 000-0000</span>
        </div>
        <div class="resume-download">
            <a href="{{ asset('documents/AJP_Resume_2025.pdf') }}" 
               download="AJP_Resume_2025.pdf"
               class="nordic-button">
                <svg class="download-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download Resume (PDF)
            </a>
        </div>
    </div>

    <section class="resume-section">
        <h2 class="section-title">PROFESSIONAL SUMMARY</h2>
        <p>
            Dynamic and adaptable <strong>engineering leader and product strategist</strong> with over a decade of experience driving innovation and team success across multiple technology stacks.
            Expert in <strong>PHP and Laravel</strong>, with extensive experience architecting and refactoring large-scale systems for performance and maintainability.
            Proven track record in <strong>leading cross-functional teams</strong>, fostering collaboration, managing lean budgets, and delivering impactful products on time.
            Passionate about mentoring engineers, building scalable SaaS platforms, and aligning technical execution with business goals.
        </p>
    </section>

    <section class="resume-section">
        <h2 class="section-title">CORE COMPETENCIES</h2>
        <ul class="competencies-list">
            <li><strong>Languages & Frameworks:</strong> PHP (Laravel Expert), JavaScript (Vue.js, React, jQuery), HTML5, CSS3, Python, Perl, C#, C++, Java</li>
            <li><strong>Databases:</strong> MySQL, MariaDB, Percona, NoSQL</li>
            <li><strong>Tools & Platforms:</strong> AWS, Linode, Git, SVN, REST APIs, Asterisk PBX, Unit & Functional Testing</li>
            <li><strong>Leadership & Product Management:</strong> Agile/SCRUM (Product Owner & SCRUM Master), Strategic Planning, Technical Roadmapping, Cross-Functional Collaboration, Budget Management, Documentation & Standards Enforcement</li>
            <li><strong>Soft Skills:</strong> Strong communicator, hands-on leader, adaptable to changing priorities, and dedicated to continuous improvement and mentorship</li>
        </ul>
    </section>

    <section class="resume-section">
        <h2 class="section-title">PROFESSIONAL EXPERIENCE</h2>

        <div class="experience-item">
            <h3 class="experience-title">Lead Software Engineer — Galactic Advisors LLC</h3>
            <p class="experience-date">Nashville, TN | Aug 2023 – Sep 2025</p>
            <ul class="experience-list">
                <li>Directed a full front-end portal overhaul, improving UI/UX, maintainability, and speed.</li>
                <li>Refactored legacy Laravel codebases, increasing extensibility and reducing technical debt.</li>
                <li>Authored detailed internal documentation to streamline onboarding and support cross-team collaboration.</li>
                <li>Mentored junior engineers, implemented coding standards, and led code reviews to ensure maintainable, testable systems.</li>
            </ul>
        </div>

        <div class="experience-item">
            <h3 class="experience-title">Director of Engineering — RAP Success Systems</h3>
            <p class="experience-date">Rochester, NY | Mar 2022 – Jun 2023</p>
            <ul class="experience-list">
                <li>Unified multiple product suites into a single, cohesive SaaS offering.</li>
                <li>Transitioned engineering organization to an Agile methodology, improving delivery timelines.</li>
                <li>Managed post-acquisition restructuring, ensuring key talent retention and budget optimization.</li>
                <li>Partnered with executive leadership to align product roadmap with business priorities.</li>
            </ul>
        </div>

        <div class="experience-item">
            <h3 class="experience-title">Lead Software Engineer — RAP Success Systems</h3>
            <p class="experience-date">Rochester, NY | Aug 2020 – Mar 2022</p>
            <ul class="experience-list">
                <li>Architected and launched a comprehensive Laravel-based REST API for third-party CRM integrations.</li>
                <li>Redesigned the database architecture to support new scaling and performance goals.</li>
                <li>Authored company-wide policies for data retention, version control, and code documentation.</li>
                <li>Expanded integration capabilities by collaborating with multiple external vendors.</li>
            </ul>
        </div>

        <div class="experience-item">
            <h3 class="experience-title">Senior Full Stack Developer — DoublePositive LLC</h3>
            <p class="experience-date">Baltimore, MD | Dec 2019 – Jun 2020</p>
            <ul class="experience-list">
                <li>Maintained and modernized LAMP-based applications integrated with large .NET ecosystems.</li>
                <li>Rebuilt and stabilized critical APIs and services, ensuring interoperability across product lines.</li>
                <li>Supported legacy product migration post-acquisition of ClickSpark.</li>
            </ul>
        </div>

        <div class="experience-item">
            <h3 class="experience-title">Web Developer — ClickSpark LLC (Acquired by DoublePositive)</h3>
            <p class="experience-date">Henrietta, NY | Apr 2012 – Dec 2019</p>
            <ul class="experience-list">
                <li>Developed internal web applications supporting call center operations, lead generation, and compliance tracking.</li>
                <li>Designed and implemented a TCPA-compliant auto-dialing system using Asterisk PBX, deployed globally.</li>
                <li>Created dynamic web tools for data analysis, lead scoring, and workforce management.</li>
            </ul>
        </div>

        <div class="experience-item">
            <h3 class="experience-title">Volunteer Firefighter — West Brighton & Henrietta Fire Districts</h3>
            <p class="experience-date">Brighton & Henrietta, NY | Feb 2011 – Jan 2015</p>
            <ul class="experience-list">
                <li>Demonstrated leadership, teamwork, and decision-making under high-pressure conditions.</li>
                <li>Received multiple certifications in emergency response and crisis management.</li>
            </ul>
        </div>
    </section>

    <section class="resume-section">
        <h2 class="section-title">EDUCATION</h2>
        <p class="education-degree"><strong>Bachelor of Science (B.S.), Computer Science (Coursework Completed)</strong></p>
        <p class="education-school">Rochester Institute of Technology — Rochester, NY</p>
    </section>
</div>

@endsection

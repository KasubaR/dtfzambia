@extends('layouts.app')

@section('title', 'Digital Future Labs — Build Digital Skills for the Future')
@section('meta_description', 'Digital Future Labs provides industry-aligned digital skills training for Zambian entrepreneurs and professionals. Apply for our 10-day hybrid cohorts today.')

@push('head')
<style>
    .home-hero {
        background-color: var(--color-dark-bg);
        position: relative;
        overflow: hidden;
        padding: 7rem 0 5rem;
    }

    .home-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 60% 50% at 80% 50%, rgba(172,193,55,.13) 0%, transparent 70%),
            radial-gradient(ellipse 40% 60% at 10% 80%, rgba(16,76,157,.35) 0%, transparent 65%);
        pointer-events: none;
    }

    .home-hero-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
        background-size: 48px 48px;
        pointer-events: none;
    }
</style>
@endpush

@section('content')

{{-- ════════════════════════════════════════════════════════════
     1. HERO
════════════════════════════════════════════════════════════ --}}
<section class="home-hero">

    <div class="home-hero-grid"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            {{-- Copy --}}
            <div class="lg:col-span-8">
                <h1 class="text-[clamp(2.4rem,5vw,3.5rem)] font-extrabold font-headline leading-[1.1] mb-8 animate-fade-up delay-100 text-white">
                    Build Digital Skills<br>
                    <span style="color: var(--color-green);">for the Future</span>
                </h1>

                <p class="text-lg leading-relaxed mb-10 max-w-2xl animate-fade-up delay-200"
                   style="color: rgba(255,255,255,.65);">
                    Digital Future Labs provides industry-aligned training for entrepreneurs and professionals, bridging the gap between local talent and global digital excellence.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 animate-fade-up delay-300">
                    <a href="{{ route('enrollment.create') }}" class="btn-primary text-sm py-4 px-8">
                        Apply Now
                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </a>
                    <a href="#courses" class="btn-outline text-sm py-4 px-8"
                       style="border-color: rgba(255,255,255,.3); color: white;">View Courses</a>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════════
     2. ABOUT PREVIEW
════════════════════════════════════════════════════════════ --}}
<section id="about" class="py-24" style="background-color: var(--color-surface-low);">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">

            <div class="relative flex items-center justify-center" data-animate>
                <div class="rounded-xl overflow-hidden flex items-center justify-center p-12"
                     style="box-shadow: var(--shadow-lg); background: var(--color-surface-low); width:100%">
                    <img src="{{ asset('images/DFL-Logo-Files-02.svg') }}"
                         alt="Digital Future Labs"
                         class="w-full max-w-xs h-auto" />
                </div>
            </div>

            <div data-animate>
                <h2 class="section-title text-3xl lg:text-4xl font-extrabold mb-6">The Visionary Ledger</h2>
                <p class="text-lg leading-relaxed mb-8" style="color: var(--color-text-muted);">
                    We are more than a lab — we are a prestigious gateway to innovation. Digital Future Labs bridges the technical divide, offering hands-on mentorship and world-class digital resources to the next generation of Zambian leaders.
                </p>
                <a href="#courses"
                   class="inline-flex items-center gap-2 font-bold text-sm group"
                   style="color: var(--color-primary);">
                    Learn More about our Mission
                    <span class="material-symbols-outlined transition-transform duration-200 group-hover:translate-x-1">trending_flat</span>
                </a>
            </div>

        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════════
     3. COURSES
════════════════════════════════════════════════════════════ --}}
<section id="courses" class="py-24" style="background-color: var(--color-surface);">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="text-center mb-16" data-animate>
            <h2 class="section-title text-4xl font-extrabold mb-4">Our Curriculum</h2>
            <p class="max-w-xl mx-auto" style="color: var(--color-text-muted);">
                Master the tools of the modern economy with our intensive 10-day hybrid cohorts.
            </p>
        </div>

        @if ($courses->isEmpty())
            <p class="text-center col-span-3" style="color: var(--color-text-muted);">No courses available yet. Check back soon.</p>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($courses as $course)
                @include('partials.course-card', ['course' => $course])
            @endforeach
        </div>
        @endif
    </div>
</section>


{{-- ════════════════════════════════════════════════════════════
     4. PRICING + STATS
════════════════════════════════════════════════════════════ --}}
<section id="pricing" class="py-24 relative overflow-hidden" style="background-color: var(--color-dark-bg); color: white;">

    {{-- Glow orbs --}}
    <div class="absolute top-0 left-0 w-96 h-96 rounded-full pointer-events-none"
         style="background: radial-gradient(circle, rgba(16,76,157,.6) 0%, transparent 70%); transform: translate(-40%,-40%);"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full pointer-events-none"
         style="background: radial-gradient(circle, rgba(172,193,55,.25) 0%, transparent 70%); transform: translate(40%,40%);"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">

            {{-- Pricing --}}
            <div data-animate>
                {{-- Special Offer Banner --}}
                <div style="
                    display: flex;
                    align-items: center;
                    gap: 0.75rem;
                    background: linear-gradient(135deg, rgba(172,193,55,0.18) 0%, rgba(172,193,55,0.08) 100%);
                    border: 1px solid rgba(172,193,55,0.55);
                    border-radius: 0.75rem;
                    padding: 0.85rem 1.25rem;
                    margin-bottom: 1.75rem;
                ">
                    <span class="material-symbols-outlined" style="color: var(--color-green); font-size: 1.3rem; flex-shrink:0;">campaign</span>
                    <p style="margin:0; font-size: 0.875rem; line-height: 1.5; color: rgba(255,255,255,0.95);">
                        <span style="font-weight: 800; color: var(--color-green); letter-spacing: 0.04em; text-transform: uppercase; font-size: 0.75rem;">Special Offer</span><br>
                        Current cohort is <strong style="color:#fff;">fully sponsored</strong> — Apply Free!
                    </p>
                </div>

                <p class="section-eyebrow" style="color: var(--color-green);">Tuition Fees</p>
                <h2 class="text-4xl font-extrabold font-headline mb-4">Investment in Your Future</h2>
                <p class="mb-10 leading-relaxed" style="color: rgba(255,255,255,.65);">
                    Premium education designed for those who want to lead the digital revolution.
                </p>

                <div class="space-y-4 mb-8">
                    @foreach ([
                        ['1 Course',  'K1,750', false],
                        ['2 Courses', 'K3,000', true],
                        ['3 Courses', 'K4,750', false],
                    ] as [$tier, $price, $highlight])
                    <div class="flex items-center justify-between px-6 py-5 rounded-xl"
                         style="background: {{ $highlight ? 'rgba(255,255,255,.12)' : 'rgba(255,255,255,.05)' }};
                                border: 1px solid {{ $highlight ? 'rgba(172,193,55,.5)' : 'rgba(255,255,255,.1)' }};">
                        <span class="text-base font-semibold">{{ $tier }}</span>
                        <span style="display:flex; flex-direction:column; align-items:flex-end; gap:0.2rem;">
                            <span class="text-2xl font-extrabold font-headline"
                                  style="text-decoration:line-through; opacity:0.45; color:{{ $highlight ? 'var(--color-green)' : 'white' }};">{{ $price }}</span>
                            <span style="display:inline-flex; align-items:center; gap:0.2rem;
                                         font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em;
                                         color:var(--color-green); background:rgba(172,193,55,0.15);
                                         border:1px solid rgba(172,193,55,0.4); border-radius:999px;
                                         padding:0.1rem 0.55rem 0.1rem 0.3rem;">
                                <span class="material-symbols-outlined" style="font-size:0.75rem;">volunteer_activism</span>
                                Sponsored
                            </span>
                        </span>
                    </div>
                    @endforeach
                </div>

            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 gap-6" data-animate>
                @foreach ([
                    [$studentCount . '+',  'Students Trained',  'var(--color-green)'],
                    ['12',   'Active Modules',     '#b1c5ff'],
                    ['98%',  'Satisfaction Rate',  'var(--color-green)'],
                    ['24/7', 'Mentorship Access',  'white'],
                ] as [$num, $label, $color])
                <div class="p-8 rounded-2xl text-center"
                     style="background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.08);">
                    <div class="text-5xl font-extrabold font-headline mb-2"
                         style="color: {{ $color }};" data-counter>{{ $num }}</div>
                    <div class="text-xs font-semibold uppercase tracking-widest"
                         style="color: rgba(255,255,255,.55);">{{ $label }}</div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════════
     5. WHY CHOOSE US + WHO IS THIS FOR
════════════════════════════════════════════════════════════ --}}
<section class="py-24" style="background-color: var(--color-surface);">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

            {{-- Why --}}
            <div class="lg:col-span-7" data-animate>
                <h2 class="section-title text-3xl font-extrabold mb-10">Why Future Labs?</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    @foreach ([
                        ['handyman',   'Hands-on Training',       'We don\'t just teach theory — you build real portfolio projects.'],
                        ['hub',        'Hybrid Learning',          'Flexibility to learn online with intensive in-person sessions.'],
                        ['trending_up','Industry Relevant',        'Curriculum designed by active professionals in global tech.'],
                        ['groups',     'Entrepreneurial Focus',    'Designed for those ready to launch or scale their ventures.'],
                    ] as [$icon, $title, $desc])
                    <div class="space-y-3 p-6 rounded-xl transition-all duration-200 hover:shadow-md"
                         style="border: 1px solid var(--color-border);">
                        <span class="material-symbols-outlined text-3xl" style="color: var(--color-green);">{{ $icon }}</span>
                        <h4 class="font-bold">{{ $title }}</h4>
                        <p class="text-sm leading-relaxed" style="color: var(--color-text-muted);">{{ $desc }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Who --}}
            <div class="lg:col-span-5" data-animate>
                <div class="p-10 rounded-2xl h-full"
                     style="background: var(--color-surface-mid); border: 1px solid var(--color-border);">
                    <p class="section-eyebrow">Target Audience</p>
                    <h2 class="section-title text-2xl font-extrabold mb-8">Who is this for?</h2>
                    <div class="space-y-5">
                        @foreach ([
                            ['person',     'Students & Graduates'],
                            ['storefront', 'Entrepreneurs'],
                            ['badge',      'Corporate Professionals'],
                            ['stairs',     'Total Beginners'],
                        ] as [$icon, $label])
                        <div class="flex items-center gap-4 group cursor-default">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0 transition-all duration-200"
                                 style="background: var(--color-primary-light); color: var(--color-primary);"
                                 onmouseover="this.style.background='var(--color-primary)';this.style.color='white';"
                                 onmouseout="this.style.background='var(--color-primary-light)';this.style.color='var(--color-primary)';">
                                <span class="material-symbols-outlined">{{ $icon }}</span>
                            </div>
                            <span class="font-bold">{{ $label }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════════
     6. HOW IT WORKS
════════════════════════════════════════════════════════════ --}}
<section class="py-24" style="background-color: var(--color-surface-low);">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="text-center mb-16" data-animate>
            <h2 class="section-title text-3xl font-extrabold">The Journey to Success</h2>
        </div>

        <div class="relative">
            {{-- Connector line --}}
            <div class="hidden lg:block absolute top-1/2 left-0 w-full h-0.5 -translate-y-1/2 -z-0"
                 style="background: linear-gradient(to right, var(--color-primary-light), var(--color-green-light));"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative z-10">
                @foreach ([
                    ['1', 'Register',     'Create your account',          false],
                    ['2', 'Apply',        'Select your course',           false],
                    ['3', 'Get Approved', 'Wait for confirmation',        true],
                    ['4', 'Enrol',        'Start learning — Day 1!',      false],
                ] as [$step, $title, $desc, $isGreen])
                <div class="p-6 rounded-xl text-center shadow-sm"
                     style="background: white; border: {{ $isGreen ? '2px solid var(--color-green)' : '1px solid var(--color-border)' }};"
                     data-animate>
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold mx-auto mb-4 text-sm"
                         style="background-color: {{ $isGreen ? 'var(--color-green)' : 'var(--color-primary)' }}; color: white;">
                        {{ $step }}
                    </div>
                    <h5 class="font-bold mb-1">{{ $title }}</h5>
                    <p class="text-xs" style="color: var(--color-text-muted);">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>


{{-- ════════════════════════════════════════════════════════════
     7. CTA BANNER
════════════════════════════════════════════════════════════ --}}
<section class="py-24" style="background-color: var(--color-surface);">
    <div class="max-w-5xl mx-auto px-6 lg:px-8" data-animate>
        <div class="relative overflow-hidden rounded-3xl p-12 lg:p-16 text-center text-white"
             style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 60%, #0a2855 100%);
                    box-shadow: var(--shadow-lg);">

            {{-- Decorative blobs --}}
            <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full pointer-events-none"
                 style="background: var(--color-green); opacity: .15; filter: blur(60px);"></div>
            <div class="absolute -bottom-20 -left-20 w-64 h-64 rounded-full pointer-events-none"
                 style="background: rgba(172,193,55,.3); filter: blur(60px);"></div>

            <div class="relative z-10">
                <span class="badge mb-6 inline-block" style="background: rgba(172,193,55,.2); color: var(--color-green);">
                    Limited Spots Available
                </span>
                <h2 class="text-4xl lg:text-5xl font-extrabold font-headline mb-6">
                    Start Your Digital Journey Today
                </h2>
                <p class="mb-10 max-w-xl mx-auto text-lg" style="color: rgba(255,255,255,.75);">
                    Join hundreds of Zambian professionals scaling their careers through Digital Future Labs.
                </p>
                <a href="{{ route('enrollment.create') }}"
                   class="inline-flex items-center gap-2 px-10 py-5 rounded-xl font-bold text-sm uppercase tracking-widest transition-all duration-200"
                   style="background: white; color: var(--color-primary);"
                   onmouseover="this.style.background='var(--color-green-light)'; this.style.color='var(--color-green-dark)';"
                   onmouseout="this.style.background='white'; this.style.color='var(--color-primary)';">
                    Apply Now — It's Free
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>

        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════════
     8. CONTACT
════════════════════════════════════════════════════════════ --}}
<section id="contact" class="py-24" style="background-color: var(--color-surface-low);">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20">

            {{-- Contact info + map --}}
            <div data-animate>
                <h2 class="text-3xl font-bold font-headline mb-8" style="color: var(--color-primary);">Get in Touch</h2>
                <div class="space-y-7 mb-10">
                    @foreach ([
                        ['mail',        'Email Us',  'info@dflzambia.com', 'mailto:info@dflzambia.com'],
                        ['call',        'Phone',     '+260 960 320 384',             'tel:+260960320384'],
                        ['location_on', 'Location',  'Innovation Hub, Longacres, Lusaka', '#'],
                    ] as [$icon, $title, $value, $href])
                    <div class="flex items-start gap-4">
                        <span class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
                              style="background: var(--color-green-light);">
                            <span class="material-symbols-outlined text-sm" style="color: var(--color-green-dark);">{{ $icon }}</span>
                        </span>
                        <div>
                            <h6 class="font-bold text-sm mb-0.5">{{ $title }}</h6>
                            <a href="{{ $href }}"
                               class="text-sm transition-colors duration-200"
                               style="color: var(--color-text-muted);"
                               onmouseover="this.style.color='var(--color-primary)';"
                               onmouseout="this.style.color='var(--color-text-muted)';">
                               {{ $value }}
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="w-full h-64 rounded-xl overflow-hidden"
                     style="box-shadow: var(--shadow-md);">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3846.Longacres!2d28.3228!3d-15.4167!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19408b3c8e3a1c4f%3A0x5a6e2a3d8f2e1b0a!2sLongacres%2C%20Lusaka%2C%20Zambia!5e0!3m2!1sen!2szm!4v1700000000000"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Digital Future Labs location">
                    </iframe>
                </div>
            </div>

            {{-- Form --}}
            <div data-animate>
                <form id="contact-form"
                      action="{{ route('contact.store') }}"
                      method="POST"
                      class="p-10 rounded-2xl space-y-6"
                      style="background: white; border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-wider"
                                   style="color: var(--color-text-muted);" for="name">Full Name</label>
                            <input id="name" name="name" type="text" required
                                   placeholder="John Doe"
                                   class="w-full rounded-lg px-4 py-3 text-sm outline-none transition-all duration-200"
                                   style="background: var(--color-surface-low); border: 1.5px solid var(--color-border);"
                                   onfocus="this.style.borderColor='var(--color-primary)'; this.style.boxShadow='0 0 0 3px rgba(16,76,157,.1)';"
                                   onblur="this.style.borderColor='var(--color-border)'; this.style.boxShadow='none';" />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-wider"
                                   style="color: var(--color-text-muted);" for="email">Email Address</label>
                            <input id="email" name="email" type="email" required
                                   placeholder="john@example.com"
                                   class="w-full rounded-lg px-4 py-3 text-sm outline-none transition-all duration-200"
                                   style="background: var(--color-surface-low); border: 1.5px solid var(--color-border);"
                                   onfocus="this.style.borderColor='var(--color-primary)'; this.style.boxShadow='0 0 0 3px rgba(16,76,157,.1)';"
                                   onblur="this.style.borderColor='var(--color-border)'; this.style.boxShadow='none';" />
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold uppercase tracking-wider"
                               style="color: var(--color-text-muted);" for="inquiry">Inquiry Type</label>
                        <select id="inquiry" name="inquiry"
                                class="w-full rounded-lg px-4 py-3 text-sm outline-none transition-all duration-200"
                                style="background: var(--color-surface-low); border: 1.5px solid var(--color-border);"
                                onfocus="this.style.borderColor='var(--color-primary)';"
                                onblur="this.style.borderColor='var(--color-border)';">
                            <option value="">Select an option…</option>
                            <option value="admission">Admission Information</option>
                            <option value="sponsorship">Sponsorship Opportunities</option>
                            <option value="partnership">Business Partnerships</option>
                            <option value="general">General Enquiry</option>
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold uppercase tracking-wider"
                               style="color: var(--color-text-muted);" for="message">Message</label>
                        <textarea id="message" name="message" rows="4" required
                                  placeholder="How can we help you?"
                                  class="w-full rounded-lg px-4 py-3 text-sm outline-none transition-all duration-200 resize-none"
                                  style="background: var(--color-surface-low); border: 1.5px solid var(--color-border);"
                                  onfocus="this.style.borderColor='var(--color-primary)'; this.style.boxShadow='0 0 0 3px rgba(16,76,157,.1)';"
                                  onblur="this.style.borderColor='var(--color-border)'; this.style.boxShadow='none';"></textarea>
                    </div>

                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                    @error('g-recaptcha-response')
                        <p class="text-xs mt-1" style="color:var(--color-danger)">{{ $message }}</p>
                    @enderror

                    <button type="submit"
                            class="btn-primary w-full justify-center py-4 text-xs">
                        Send Message
                        <span class="material-symbols-outlined text-base">send</span>
                    </button>

                </form>
            </div>

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Entrance animation init — runs after app.js has loaded
document.querySelectorAll('[data-animate]').forEach((el, i) => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity .55s ease, transform .55s ease';
    el.style.transitionDelay = `${(i % 3) * 0.1}s`;
});

const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.12 });

document.querySelectorAll('[data-animate]').forEach(el => revealObserver.observe(el));
</script>
@endpush

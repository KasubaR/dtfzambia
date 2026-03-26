{{-- resources/views/partials/footer.blade.php --}}
<footer style="background-color: var(--color-surface-low); border-top: 1px solid var(--color-border);">

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

            {{-- Brand column --}}
            <div class="lg:col-span-1">
                <a href="{{ url('/') }}" class="flex items-center mb-5">
                    <img src="{{ asset('images/DFL-Logo-Files-02.svg') }}"
                         alt="Digital Future Labs"
                         class="h-10 w-auto" />
                </a>
                <p class="text-sm leading-relaxed mb-6" style="color: var(--color-text-muted);">
                    Empowering the next generation of digital entrepreneurs through specialised training and global networking.
                </p>
                <div class="flex gap-3">
                    <a href="#" aria-label="LinkedIn"
                       class="w-9 h-9 rounded-full flex items-center justify-center transition-all duration-200"
                       style="background: white; color: var(--color-primary); border: 1px solid var(--color-border);"
                       onmouseover="this.style.backgroundColor='var(--color-primary)';this.style.color='white';"
                       onmouseout="this.style.backgroundColor='white';this.style.color='var(--color-primary)';">
                        <span class="material-symbols-outlined text-lg">business_center</span>
                    </a>
                    <a href="#" aria-label="Twitter / X"
                       class="w-9 h-9 rounded-full flex items-center justify-center transition-all duration-200"
                       style="background: white; color: var(--color-primary); border: 1px solid var(--color-border);"
                       onmouseover="this.style.backgroundColor='var(--color-primary)';this.style.color='white';"
                       onmouseout="this.style.backgroundColor='white';this.style.color='var(--color-primary)';">
                        <span class="material-symbols-outlined text-lg">share</span>
                    </a>
                    <a href="#" aria-label="Facebook"
                       class="w-9 h-9 rounded-full flex items-center justify-center transition-all duration-200"
                       style="background: white; color: var(--color-primary); border: 1px solid var(--color-border);"
                       onmouseover="this.style.backgroundColor='var(--color-primary)';this.style.color='white';"
                       onmouseout="this.style.backgroundColor='white';this.style.color='var(--color-primary)';">
                        <span class="material-symbols-outlined text-lg">group</span>
                    </a>
                </div>
            </div>

            {{-- Quick links --}}
            <div>
                <h5 class="text-[0.7rem] font-bold uppercase tracking-widest mb-5"
                    style="color: var(--color-primary);">Quick Links</h5>
                <ul class="space-y-3">
                    @foreach ([
                        ['Admissions',       '#courses'],
                        ['Curriculum',       '#courses'],
                        ['Scholarships',     '#pricing'],
                        ['Partner with Us',  '#contact'],
                        ['About Us',         '#about'],
                    ] as [$label, $anchor])
                    <li>
                        <a href="{{ url('/') }}{{ $anchor }}"
                           class="text-sm transition-colors duration-200"
                           style="color: var(--color-text-muted);"
                           onmouseover="this.style.color='var(--color-primary)';"
                           onmouseout="this.style.color='var(--color-text-muted)';">
                            {{ $label }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Social media --}}
            <div>
                <h5 class="text-[0.7rem] font-bold uppercase tracking-widest mb-5"
                    style="color: var(--color-primary);">Follow Us</h5>
                <ul class="space-y-3">
                    @foreach (['LinkedIn', 'Twitter (X)', 'Facebook', 'Instagram', 'YouTube'] as $platform)
                    <li>
                        <a href="#"
                           class="text-sm transition-colors duration-200"
                           style="color: var(--color-text-muted);"
                           onmouseover="this.style.color='var(--color-green)';"
                           onmouseout="this.style.color='var(--color-text-muted)';">
                            {{ $platform }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h5 class="text-[0.7rem] font-bold uppercase tracking-widest mb-5"
                    style="color: var(--color-primary);">Contact</h5>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-sm mt-0.5"
                              style="color: var(--color-green);">location_on</span>
                        <span class="text-sm leading-relaxed" style="color: var(--color-text-muted);">
                            Innovation Hub, Longacres<br>Lusaka, Zambia
                        </span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-sm"
                              style="color: var(--color-green);">mail</span>
                        <a href="mailto:info@dflzambia.com"
                           class="text-sm transition-colors duration-200"
                           style="color: var(--color-text-muted);"
                           onmouseover="this.style.color='var(--color-primary)';"
                           onmouseout="this.style.color='var(--color-text-muted)';">
                            info@dflzambia.com
                        </a>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-sm"
                              style="color: var(--color-green);">call</span>
                        <a href="tel:+260970000000"
                           class="text-sm transition-colors duration-200"
                           style="color: var(--color-text-muted);"
                           onmouseover="this.style.color='var(--color-primary)';"
                           onmouseout="this.style.color='var(--color-text-muted)';">
                            +260 970 000 000
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    {{-- Bottom bar --}}
    <div style="border-top: 1px solid var(--color-border);">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs" style="color: var(--color-text-muted);">
                &copy; {{ date('Y') }} Digital Future Labs. All rights reserved.
            </p>
            <div class="flex gap-6 items-center">
                @foreach (['Privacy Policy', 'Terms of Service', 'Cookie Policy'] as $link)
                <a href="#"
                   class="text-xs transition-colors duration-200"
                   style="color: var(--color-text-muted);"
                   onmouseover="this.style.color='var(--color-primary)';"
                   onmouseout="this.style.color='var(--color-text-muted)';">
                    {{ $link }}
                </a>
                @endforeach
                @auth
                    @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}"
                       class="text-xs font-medium flex items-center gap-1 px-3 py-1 rounded-full transition-all duration-200"
                       style="color: var(--color-primary); border: 1px solid var(--color-primary);"
                       onmouseover="this.style.backgroundColor='var(--color-primary)';this.style.color='white';"
                       onmouseout="this.style.backgroundColor='transparent';this.style.color='var(--color-primary)';">
                        <span class="material-symbols-outlined" style="font-size: 13px;">admin_panel_settings</span>
                        Admin Panel
                    </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

</footer>

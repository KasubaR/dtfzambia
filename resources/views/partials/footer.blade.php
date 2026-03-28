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
            </div>

            {{-- Quick links --}}
            <div>
                <h5 class="text-[0.7rem] font-bold uppercase tracking-widest mb-5"
                    style="color: var(--color-primary);">Quick Links</h5>
                <ul class="space-y-3">
                    @foreach ([
                        ['Apply Now',        route('enrollment.create')],
                        ['Partner with Us',  '#contact'],
                        ['About Us',         '#about'],
                    ] as [$label, $anchor])
                    <li>
                        <a href="{{ str_starts_with($anchor, 'http') ? $anchor : url('/') . $anchor }}"
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
                <div class="flex flex-wrap gap-3">

                    {{-- LinkedIn --}}
                    <a href="https://www.linkedin.com/company/digitalfuturelab/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"
                       class="w-9 h-9 rounded-full flex items-center justify-center transition-all duration-200"
                       style="background: white; color: var(--color-primary); border: 1px solid var(--color-border);"
                       onmouseover="this.style.backgroundColor='#0a66c2';this.style.color='white';this.style.borderColor='#0a66c2';"
                       onmouseout="this.style.backgroundColor='white';this.style.color='var(--color-primary)';this.style.borderColor='var(--color-border)';">
                        <i class="fa-brands fa-linkedin-in" style="font-size:15px"></i>
                    </a>

                    {{-- Facebook --}}
                    <a href="https://www.facebook.com/share/17NTber2QY/?mibextid=wwXIfr" target="_blank" rel="noopener noreferrer" aria-label="Facebook"
                       class="w-9 h-9 rounded-full flex items-center justify-center transition-all duration-200"
                       style="background: white; color: var(--color-primary); border: 1px solid var(--color-border);"
                       onmouseover="this.style.backgroundColor='#1877f2';this.style.color='white';this.style.borderColor='#1877f2';"
                       onmouseout="this.style.backgroundColor='white';this.style.color='var(--color-primary)';this.style.borderColor='var(--color-border)';">
                        <i class="fa-brands fa-facebook-f" style="font-size:15px"></i>
                    </a>

                    {{-- Instagram --}}
                    <div class="relative inline-block" id="ig-wrapper">
                        <a href="#" aria-label="Instagram"
                           class="w-9 h-9 rounded-full flex items-center justify-center transition-all duration-200"
                           style="background: white; color: var(--color-primary); border: 1px solid var(--color-border);"
                           onmouseover="this.style.backgroundColor='#e1306c';this.style.color='white';this.style.borderColor='#e1306c';"
                           onmouseout="this.style.backgroundColor='white';this.style.color='var(--color-primary)';this.style.borderColor='var(--color-border)';"
                           onclick="event.preventDefault();var t=document.getElementById('ig-tooltip');t.style.opacity='1';t.style.pointerEvents='auto';clearTimeout(window._igTimer);window._igTimer=setTimeout(function(){t.style.opacity='0';t.style.pointerEvents='none';},2000);">
                            <i class="fa-brands fa-instagram" style="font-size:15px"></i>
                        </a>
                        <span id="ig-tooltip"
                              class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs rounded whitespace-nowrap transition-opacity duration-200"
                              style="background:#333;color:#fff;opacity:0;pointer-events:none;">Coming Soon</span>
                    </div>

                    {{-- TikTok --}}
                    <a href="https://www.tiktok.com/@digitalfuturelab" target="_blank" rel="noopener noreferrer" aria-label="TikTok"
                       class="w-9 h-9 rounded-full flex items-center justify-center transition-all duration-200"
                       style="background: white; color: var(--color-primary); border: 1px solid var(--color-border);"
                       onmouseover="this.style.backgroundColor='#010101';this.style.color='white';this.style.borderColor='#010101';"
                       onmouseout="this.style.backgroundColor='white';this.style.color='var(--color-primary)';this.style.borderColor='var(--color-border)';">
                        <i class="fa-brands fa-tiktok" style="font-size:15px"></i>
                    </a>

                </div>
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
                        <a href="tel:+260960320384"
                           class="text-sm transition-colors duration-200"
                           style="color: var(--color-text-muted);"
                           onmouseover="this.style.color='var(--color-primary)';"
                           onmouseout="this.style.color='var(--color-text-muted)';">
                            +260 960 320 384
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
            </div>
        </div>
    </div>

</footer>

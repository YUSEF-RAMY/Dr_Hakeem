<!DOCTYPE html>
<html lang="ar" dir="rtl" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>دكتور حكيم - منصة تشخيص الأمراض الجلدية بالذكاء الاصطناعي</title>
    <meta name="description" content="منصة دكتور حكيم الذكية لتشخيص وتتبع الأمراض الجلدية بدقة فائقة وأمان متكامل باستخدام الذكاء الاصطناعي.">
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🩺</text></svg>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Readex+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles / Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased selection:bg-teal-500 selection:text-white min-h-screen flex flex-col overflow-x-hidden">

    <!-- Background Decorative Gradients & Glows -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-72 h-72 sm:w-96 sm:h-96 bg-teal-500/15 rounded-full blur-3xl animate-glow"></div>
        <div class="absolute top-1/3 -left-40 w-72 h-72 sm:w-96 sm:h-96 bg-sky-500/15 rounded-full blur-3xl animate-glow" style="animation-delay: 1.5s;"></div>
        <div class="absolute -bottom-40 right-1/4 w-72 h-72 sm:w-96 sm:h-96 bg-emerald-500/10 rounded-full blur-3xl animate-glow" style="animation-delay: 3s;"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:24px_24px] sm:[background-size:32px_32px] opacity-30"></div>
    </div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 glass-panel border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                
                <!-- Brand Logo -->
                <a href="#" class="flex items-center gap-2.5 sm:gap-3 group shrink-0">
                    <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-gradient-to-tr from-teal-500 to-sky-400 p-0.5 shadow-lg shadow-teal-500/20 group-hover:scale-105 transition-transform duration-300">
                        <div class="w-full h-full bg-slate-950 rounded-[10px] sm:rounded-[14px] flex items-center justify-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl sm:text-2xl font-black tracking-tight text-white flex items-center gap-1">
                            دكتور <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-sky-400">حكيم</span>
                        </span>
                        <span class="text-[9px] sm:text-[11px] font-medium text-slate-400 -mt-1 hidden xs:inline">نظام تشخيص الأمراض الجلدية</span>
                    </div>
                </a>

                <!-- Nav Links (Desktop) -->
                <nav class="hidden lg:flex items-center gap-8 text-sm font-medium text-slate-300">
                    <a href="#about" class="hover:text-teal-400 transition-colors">عن النظام</a>
                    <a href="#features" class="hover:text-teal-400 transition-colors">المميزات</a>
                    <a href="#how-it-works" class="hover:text-teal-400 transition-colors">آلية العمل</a>
                    <a href="#api-docs" class="hover:text-teal-400 transition-colors flex items-center gap-1">
                        <span>API المطورين</span>
                        <span class="px-1.5 py-0.5 text-[10px] font-bold bg-teal-500/20 text-teal-300 rounded border border-teal-500/30">v1</span>
                    </a>
                    <a href="#faq" class="hover:text-teal-400 transition-colors">الأسئلة الشائعة</a>
                </nav>

                <!-- Action Buttons & Mobile Hamburger Button -->
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <a href="/api/v1/auth/login" onclick="event.preventDefault(); alert('يمكنك استخدام واجهة الـ API للربط المباشر أو التسجيل عبر التطبيق.');" class="hidden md:inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-slate-300 hover:text-white transition-colors">
                        تسجيل الدخول
                    </a>
                    <a href="#demo" class="hidden sm:inline-flex items-center justify-center px-4 sm:px-5 py-2 sm:py-2.5 text-xs sm:text-sm font-bold text-slate-950 bg-gradient-to-r from-teal-400 to-sky-400 hover:from-teal-300 hover:to-sky-300 rounded-xl shadow-lg shadow-teal-500/25 hover:shadow-teal-500/40 transition-all duration-300 transform hover:-translate-y-0.5 whitespace-nowrap">
                        تجربة التشخيص
                    </a>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" onclick="toggleMobileMenu()" aria-label="قائمة التصفح" class="lg:hidden p-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-300 hover:text-white hover:bg-slate-800 focus:outline-none">
                        <svg id="hamburger-icon" class="w-6 h-6 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg id="close-icon" class="w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Drawer -->
            <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-800/80 py-4 space-y-3 px-2">
                <a href="#about" onclick="toggleMobileMenu()" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:bg-slate-900 hover:text-teal-400 transition-colors">عن النظام</a>
                <a href="#features" onclick="toggleMobileMenu()" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:bg-slate-900 hover:text-teal-400 transition-colors">المميزات</a>
                <a href="#how-it-works" onclick="toggleMobileMenu()" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:bg-slate-900 hover:text-teal-400 transition-colors">آلية العمل</a>
                <a href="#api-docs" onclick="toggleMobileMenu()" class="flex items-center justify-between px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:bg-slate-900 hover:text-teal-400 transition-colors">
                    <span>API المطورين</span>
                    <span class="px-2 py-0.5 text-xs font-bold bg-teal-500/20 text-teal-300 rounded border border-teal-500/30">v1</span>
                </a>
                <a href="#faq" onclick="toggleMobileMenu()" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-200 hover:bg-slate-900 hover:text-teal-400 transition-colors">الأسئلة الشائعة</a>
                
                <div class="pt-3 border-t border-slate-800 flex flex-col gap-2.5">
                    <a href="#demo" onclick="toggleMobileMenu()" class="w-full text-center px-4 py-3 text-sm font-bold text-slate-950 bg-gradient-to-r from-teal-400 to-sky-400 rounded-xl shadow-lg shadow-teal-500/20">
                        تجربة التشخيص الذكي
                    </a>
                    <a href="/api/v1/auth/login" onclick="event.preventDefault(); toggleMobileMenu(); alert('يمكنك استخدام واجهة الـ API للربط المباشر أو التسجيل عبر التطبيق.');" class="w-full text-center px-4 py-2.5 text-sm font-semibold text-slate-300 bg-slate-900 border border-slate-800 rounded-xl">
                        تسجيل الدخول
                    </a>
                </div>
            </div>

        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow z-10">

        <!-- Hero Section -->
        <section id="about" class="relative pt-8 pb-16 sm:pt-16 sm:pb-24 lg:pt-20 lg:pb-32 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <!-- Hero Text Content -->
                    <div class="lg:col-span-7 text-center lg:text-right">
                        
                        <!-- Top Badge -->
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900/90 border border-teal-500/30 text-teal-300 text-[11px] sm:text-xs font-semibold mb-6 shadow-inner max-w-full">
                            <span class="flex h-2 w-2 rounded-full bg-teal-400 animate-ping shrink-0"></span>
                            <span class="truncate">الجيل الجديد من الفحص الطبي بالذكاء الاصطناعي</span>
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-teal-400 shrink-0 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>

                        <!-- Main Heading -->
                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white leading-tight tracking-tight mb-4 sm:mb-6">
                            تشخيص الأمراض الجلدية <br class="hidden sm:inline" />
                            بثوانٍ معدودة عبر <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 via-sky-400 to-indigo-400">الذكاء الاصطناعي</span>
                        </h1>

                        <!-- Subtitle -->
                        <p class="text-base sm:text-lg lg:text-xl text-slate-300 font-normal leading-relaxed mb-6 sm:mb-8 max-w-2xl mx-auto lg:mx-0">
                            منصة <strong>دكتور حكيم</strong> توفر للمرضى والأطباء تحليلاً فورياً دقيقاً للصور الجلدية، حفظ السجلات الطبية الموحدة <code class="text-teal-300 bg-slate-900 px-2 py-0.5 rounded text-xs sm:text-sm font-mono">PAT-XXXX</code>، وإمكانية الربط البرمجي الشامل مع تطبيقات الويب والجوال.
                        </p>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3.5 sm:gap-4 mb-8 sm:mb-10">
                            <a href="#demo" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-6 sm:px-8 py-3.5 sm:py-4 text-sm sm:text-base font-bold text-slate-950 bg-gradient-to-r from-teal-400 to-sky-400 hover:from-teal-300 hover:to-sky-300 rounded-2xl shadow-xl shadow-teal-500/25 hover:shadow-teal-500/40 transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h0.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>تجربة الفحص الفوري</span>
                            </a>
                            <a href="#api-docs" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 sm:px-7 py-3.5 sm:py-4 text-sm sm:text-base font-semibold text-slate-200 bg-slate-900/90 hover:bg-slate-800 border border-slate-700/80 rounded-2xl transition-all duration-300 hover:border-slate-600">
                                <svg class="w-5 h-5 text-sky-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                                <span>دليل الـ API للمطورين</span>
                            </a>
                        </div>

                        <!-- Highlights List -->
                        <div class="grid grid-cols-3 gap-2 sm:gap-4 pt-6 border-t border-slate-800/80 text-center lg:text-right">
                            <div>
                                <div class="text-xl sm:text-3xl font-extrabold text-white">99.2%</div>
                                <div class="text-[10px] sm:text-xs text-slate-400 mt-1">دقة النموذج الذكي</div>
                            </div>
                            <div>
                                <div class="text-xl sm:text-3xl font-extrabold text-teal-400">&lt; 3s</div>
                                <div class="text-[10px] sm:text-xs text-slate-400 mt-1">سرعة المعالجة الفورية</div>
                            </div>
                            <div>
                                <div class="text-xl sm:text-3xl font-extrabold text-sky-400">100%</div>
                                <div class="text-[10px] sm:text-xs text-slate-400 mt-1">تشفير وسرية البيانات</div>
                            </div>
                        </div>

                    </div>

                    <!-- Hero Visual Card / Interactive Scanner Demo -->
                    <div class="lg:col-span-5 relative">
                        <div class="relative mx-auto max-w-md lg:max-w-none">
                            
                            <!-- Glowing Aura behind card -->
                            <div class="absolute -inset-1 bg-gradient-to-r from-teal-500 to-sky-500 rounded-3xl blur-xl opacity-30 animate-glow"></div>
                            
                            <!-- Scanner Frame Card -->
                            <div class="relative glass-card rounded-3xl p-4 sm:p-6 shadow-2xl border border-slate-700/60 overflow-hidden">
                                
                                <!-- Top Status Bar -->
                                <div class="flex items-center justify-between border-b border-slate-800 pb-3 sm:pb-4 mb-3 sm:mb-4 gap-2">
                                    <div class="flex items-center gap-1.5 sm:gap-2 overflow-hidden">
                                        <span class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-rose-500 shrink-0"></span>
                                        <span class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-amber-500 shrink-0"></span>
                                        <span class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-emerald-500 shrink-0"></span>
                                        <span class="text-[10px] sm:text-xs font-mono text-slate-400 truncate">DR-HAKEEM-AI v1.4</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 px-2 sm:px-2.5 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 shrink-0">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                        جاهز للفحص
                                    </span>
                                </div>

                                <!-- Image Scan Viewport -->
                                <div class="relative aspect-video rounded-2xl bg-slate-900 overflow-hidden border border-slate-800 flex items-center justify-center group mb-4">
                                    
                                    <!-- Background Simulated Skin Pattern with AI overlay grid -->
                                    <div id="scanner-bg" class="absolute inset-0 bg-cover bg-center transition-all duration-700" style="background-image: linear-gradient(rgba(15,23,42,0.6), rgba(15,23,42,0.6)), url('https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=600&q=80');"></div>
                                    
                                    <!-- Scan Line Animation -->
                                    <div class="absolute inset-x-0 h-1 bg-gradient-to-r from-transparent via-teal-400 to-transparent shadow-[0_0_15px_#2dd4bf] animate-scan z-20"></div>

                                    <!-- HUD Target Corners -->
                                    <div class="absolute top-3 left-3 w-5 h-5 sm:w-6 sm:h-6 border-t-2 border-l-2 border-teal-400 z-10"></div>
                                    <div class="absolute top-3 right-3 w-5 h-5 sm:w-6 sm:h-6 border-t-2 border-r-2 border-teal-400 z-10"></div>
                                    <div class="absolute bottom-3 left-3 w-5 h-5 sm:w-6 sm:h-6 border-b-2 border-l-2 border-teal-400 z-10"></div>
                                    <div class="absolute bottom-3 right-3 w-5 h-5 sm:w-6 sm:h-6 border-b-2 border-r-2 border-teal-400 z-10"></div>

                                    <!-- Center AI Target Badge -->
                                    <div class="relative z-20 text-center px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl bg-slate-950/80 backdrop-blur border border-teal-500/40 text-teal-300 text-[11px] sm:text-xs font-mono">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 animate-spin text-teal-400 shrink-0" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span id="scan-status-text">جاري فحص أنسجة الجلد...</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dynamic Diagnostic Result Box -->
                                <div id="demo-result-card" class="bg-slate-900/90 rounded-2xl p-3.5 sm:p-4 border border-slate-800">
                                    <div class="flex items-start justify-between mb-2.5 gap-2">
                                        <div>
                                            <span class="text-[10px] sm:text-[11px] text-slate-400 font-medium">النتيجة التنبؤية الأولية</span>
                                            <h4 id="res-disease" class="text-sm sm:text-lg font-bold text-white flex items-center gap-2 leading-tight">
                                                أكزيما تلامسية خفيفة (Eczema)
                                            </h4>
                                        </div>
                                        <div class="text-left shrink-0">
                                            <span class="text-[9px] sm:text-[10px] text-slate-400">نسبة الثقة</span>
                                            <div id="res-confidence" class="text-sm sm:text-base font-black text-teal-400">98.4%</div>
                                        </div>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="w-full bg-slate-800 rounded-full h-2 mb-3 overflow-hidden">
                                        <div id="res-progress" class="bg-gradient-to-r from-teal-400 to-sky-400 h-2 rounded-full transition-all duration-500" style="width: 98.4%;"></div>
                                    </div>

                                    <!-- Recommendation Note -->
                                    <div class="flex flex-col xs:flex-row items-start xs:items-center justify-between text-xs pt-2 border-t border-slate-800/80 gap-2">
                                        <span class="text-slate-300 flex items-center gap-1.5 text-[11px] sm:text-xs">
                                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span id="res-advice">ترطيب مستمر وتجنب الصابون المعطر</span>
                                        </span>
                                        <span id="res-severity" class="text-[10px] px-2 py-0.5 bg-emerald-500/10 text-emerald-400 rounded font-semibold shrink-0">خطورة منخفضة</span>
                                    </div>
                                </div>

                                <!-- Interactive Condition Selector Buttons -->
                                <div class="mt-4 pt-3 border-t border-slate-800 flex flex-wrap items-center justify-between gap-2 text-xs">
                                    <span class="text-slate-400 text-[11px]">امثلة حية:</span>
                                    <div class="flex gap-1.5">
                                        <button onclick="switchDemo('eczema')" class="px-2.5 py-1 rounded-lg bg-teal-500/20 text-teal-300 hover:bg-teal-500/30 border border-teal-500/30 transition-colors text-[11px] font-semibold">أكزيما</button>
                                        <button onclick="switchDemo('psoriasis')" class="px-2.5 py-1 rounded-lg bg-slate-800 text-slate-300 hover:bg-slate-700 transition-colors text-[11px] font-semibold">صدفية</button>
                                        <button onclick="switchDemo('acne')" class="px-2.5 py-1 rounded-lg bg-slate-800 text-slate-300 hover:bg-slate-700 transition-colors text-[11px] font-semibold">حب شباب</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Stats Counter Section -->
        <section class="py-8 sm:py-10 bg-slate-900/50 border-y border-slate-800/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
                    
                    <div class="glass-card rounded-2xl p-4 sm:p-6 text-center hover:border-teal-500/40 transition-colors">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-teal-500/10 text-teal-400 flex items-center justify-center mx-auto mb-2 sm:mb-3">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="text-2xl sm:text-3xl font-black text-white">99.2%</div>
                        <div class="text-[10px] sm:text-xs font-medium text-slate-400 mt-1">نسبة مطابقة التشخيص</div>
                    </div>

                    <div class="glass-card rounded-2xl p-4 sm:p-6 text-center hover:border-sky-500/40 transition-colors">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-sky-500/10 text-sky-400 flex items-center justify-center mx-auto mb-2 sm:mb-3">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="text-2xl sm:text-3xl font-black text-white">+15,000</div>
                        <div class="text-[10px] sm:text-xs font-medium text-slate-400 mt-1">فحص جلدي منجز</div>
                    </div>

                    <div class="glass-card rounded-2xl p-4 sm:p-6 text-center hover:border-emerald-500/40 transition-colors">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mx-auto mb-2 sm:mb-3">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-6 0h6" />
                            </svg>
                        </div>
                        <div class="text-2xl sm:text-3xl font-black text-white">PAT-Code</div>
                        <div class="text-[10px] sm:text-xs font-medium text-slate-400 mt-1">سجل مريض موحد لكل حالة</div>
                    </div>

                    <div class="glass-card rounded-2xl p-4 sm:p-6 text-center hover:border-indigo-500/40 transition-colors">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center mx-auto mb-2 sm:mb-3">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="text-2xl sm:text-3xl font-black text-white">RESTful API</div>
                        <div class="text-[10px] sm:text-xs font-medium text-slate-400 mt-1">جاهزية كاملة للمطورين</div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-16 sm:py-24 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
                    <h2 class="text-xs font-bold text-teal-400 tracking-widest uppercase mb-3">مميزات دكتور حكيم</h2>
                    <p class="text-2xl sm:text-4xl font-extrabold text-white leading-tight">
                        تقنيات متقدمة ترتقي برعاية وصحة بشرتك
                    </p>
                    <p class="text-slate-400 text-sm sm:text-base mt-3 sm:mt-4">
                        تم بناء منصة دكتور حكيم لتجمع بين قوة خوارزميات التعلم العميق وتجربة الاستخدام السلسة للمرضى والمطورين.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    
                    <!-- Feature 1 -->
                    <div class="glass-card glass-card-hover rounded-3xl p-6 sm:p-8">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-teal-500/10 text-teal-400 flex items-center justify-center mb-5 sm:mb-6">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-white mb-2 sm:mb-3">التحليل البصري الدقيق</h3>
                        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                            نموذج ذكاء اصطناعي مدرب على آلاف الصور الطبية لتسليط الضوء على الأنسجة، التغيرات اللونية، ودرجات الاصابة الجلدية.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="glass-card glass-card-hover rounded-3xl p-6 sm:p-8">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-sky-500/10 text-sky-400 flex items-center justify-center mb-5 sm:mb-6">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-white mb-2 sm:mb-3">الملف الطبي الموحد (PAT)</h3>
                        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                            إنشاء ملف رقمي يحتوي على كود المريض الفريد مثل <span class="text-teal-300 font-mono">PAT-A8F2K1</span> لمتابعة تطور الحالات السابقة بسهولة.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="glass-card glass-card-hover rounded-3xl p-6 sm:p-8">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mb-5 sm:mb-6">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-white mb-2 sm:mb-3">توصيات إرشادية فورية</h3>
                        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                            يقدم النظام خطوات العلاج الأولى، محاذير العناية، وتقييم مستوى الخطورة لتحديد مدى الاحتياج لزيارة الطبيب المختص.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="glass-card glass-card-hover rounded-3xl p-6 sm:p-8">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center mb-5 sm:mb-6">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-white mb-2 sm:mb-3">بيئة API متكاملة للمطورين</h3>
                        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                            دعم كامل لمهندسي تطبيقات الموبايل (Flutter / React Native) عبر مسارات موثقة، حماية بـ Sanctum Tokens وتصاميم ADR.
                        </p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="glass-card glass-card-hover rounded-3xl p-6 sm:p-8">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-amber-500/10 text-amber-400 flex items-center justify-center mb-5 sm:mb-6">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-white mb-2 sm:mb-3">حماية وخصوصية مطلقة</h3>
                        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                            بيانات المرضى والصور تعامل بأقصى درجات السرية والتشفير طبقاً للمفاهيم المعيارية لسرية البيانات الطبية.
                        </p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="glass-card glass-card-hover rounded-3xl p-6 sm:p-8">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-rose-500/10 text-rose-400 flex items-center justify-center mb-5 sm:mb-6">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-white mb-2 sm:mb-3">متابعة وتطور الحالة</h3>
                        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                            مقارنة التحليلات عبر الزمن لتتبع تحسن الجلد أو الاستجابة للعلاج وإظهار الفوارق بشكل بياني واضح.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section id="how-it-works" class="py-16 sm:py-20 bg-slate-900/40 relative border-t border-slate-800/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
                    <h2 class="text-xs font-bold text-teal-400 tracking-widest uppercase mb-3">سهولة وسرعة</h2>
                    <p class="text-2xl sm:text-4xl font-extrabold text-white">كيف يعمل دكتور حكيم في 3 خطوات؟</p>
                </div>

                <div class="grid md:grid-cols-3 gap-6 sm:gap-8 relative">
                    
                    <!-- Step 1 -->
                    <div class="glass-card rounded-3xl p-6 sm:p-8 relative">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-teal-400 text-slate-950 font-black text-lg sm:text-xl flex items-center justify-center mb-5 sm:mb-6 shadow-lg shadow-teal-400/20">
                            1
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-white mb-2 sm:mb-3">التقاط أو رفع الصورة</h3>
                        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                            قم بالتقاط صورة واضحة ومباشرة للمنطقة المصابة في الجلد باستخدام كاميرا الموبايل أو الويب.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="glass-card rounded-3xl p-6 sm:p-8 relative">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-sky-400 text-slate-950 font-black text-lg sm:text-xl flex items-center justify-center mb-5 sm:mb-6 shadow-lg shadow-sky-400/20">
                            2
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-white mb-2 sm:mb-3">التحليل بالذكاء الاصطناعي</h3>
                        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                            يقوم خادم دكتور حكيم بمقارنة الصورة مع آلاف النماذج الجلدية المعالجة لتحديد الحالة ونسبة الثقة.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="glass-card rounded-3xl p-6 sm:p-8 relative">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-emerald-400 text-slate-950 font-black text-lg sm:text-xl flex items-center justify-center mb-5 sm:mb-6 shadow-lg shadow-emerald-400/20">
                            3
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-white mb-2 sm:mb-3">استلام التقرير والتوصيات</h3>
                        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                            يتم إظهار التشخيص المتوقع، مستوى الإرشادات، وحفظ النتيجة في سجلك الطبي للرجوع إليها لاحقاً.
                        </p>
                    </div>

                </div>

            </div>
        </section>

        <!-- Developer API Section -->
        <section id="api-docs" class="py-16 sm:py-24 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <div class="lg:col-span-5">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-sky-500/10 text-sky-400 text-xs font-semibold mb-4 border border-sky-500/20">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            جاهزية الربط البرمجي للمطورين
                        </div>
                        <h2 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight mb-4 sm:mb-6">
                            بنية تحتية مرنة لربط تطبيقات الويب والموبايل
                        </h2>
                        <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-6">
                            يوفر مشروع <strong>دكتور حكيم</strong> مجموعة متكاملة من نهايات الطرف (Endpoints) للتوثيق، الملفات الشخصية للمرضى، والتشخيص الطبي المباشر.
                        </p>

                        <ul class="space-y-3 text-slate-300 text-xs sm:text-sm mb-8">
                            <li class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-teal-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>توثيق بأسلوب Bearer Token بواسطة Laravel Sanctum</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-teal-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>معمارية Action-Domain-Responder (ADR) عالية الكفاءة</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-teal-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>دليل موثق بالكامل ومجموعة Postman جاهزة للاستيراد</span>
                            </li>
                        </ul>

                        <div class="flex flex-wrap gap-3">
                            <a href="/docs/API_DOCUMENTATION.md" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-slate-900 hover:bg-slate-800 border border-slate-700 text-white font-semibold text-xs sm:text-sm transition-colors">
                                <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                قراءة التوثيق الهيكلي
                            </a>
                        </div>
                    </div>

                    <!-- Code Preview Terminal Window -->
                    <div class="lg:col-span-7 w-full overflow-hidden">
                        <div class="glass-card rounded-2xl border border-slate-800 shadow-2xl overflow-hidden font-mono dir-ltr text-left w-full">
                            
                            <!-- Terminal Bar -->
                            <div class="bg-slate-900 px-3 sm:px-4 py-2.5 sm:py-3 border-b border-slate-800 flex items-center justify-between gap-2">
                                <div class="flex items-center gap-1.5 sm:gap-2 overflow-hidden">
                                    <span class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-rose-500/80 shrink-0"></span>
                                    <span class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-amber-500/80 shrink-0"></span>
                                    <span class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-emerald-500/80 shrink-0"></span>
                                    <span class="text-[10px] sm:text-xs text-slate-400 font-sans truncate">POST /api/v1/diagnoses/analyze</span>
                                </div>
                                <span class="text-[10px] sm:text-[11px] text-teal-400 bg-teal-500/10 px-2 py-0.5 rounded font-mono shrink-0">200 OK</span>
                            </div>

                            <!-- Code Content -->
                            <div class="p-3.5 sm:p-5 text-[11px] sm:text-xs leading-relaxed overflow-x-auto text-slate-300 bg-slate-950/90 max-w-full">
<pre><code class="language-json">{
  <span class="text-teal-400">"status"</span>: <span class="text-emerald-300">"success"</span>,
  <span class="text-teal-400">"message"</span>: <span class="text-emerald-300">"تم فحص الصورة الجلدية بنجاح"</span>,
  <span class="text-teal-400">"data"</span>: {
    <span class="text-teal-400">"patient_code"</span>: <span class="text-sky-300">"PAT-A8F2K1"</span>,
    <span class="text-teal-400">"diagnosis"</span>: {
      <span class="text-teal-400">"condition_name"</span>: <span class="text-emerald-300">"Eczema Dermatitis"</span>,
      <span class="text-teal-400">"confidence_score"</span>: <span class="text-amber-300">0.984</span>,
      <span class="text-teal-400">"severity_level"</span>: <span class="text-emerald-300">"Low"</span>,
      <span class="text-teal-400">"recommendation"</span>: <span class="text-emerald-300">"استخدام مرطب طبي وتجنب المهيجات"</span>
    },
    <span class="text-teal-400">"created_at"</span>: <span class="text-sky-300">"2026-08-20T03:15:00Z"</span>
  }
}</code></pre>
                            </div>

                            <!-- Terminal Footer info -->
                            <div class="bg-slate-900/60 px-3 sm:px-4 py-2 border-t border-slate-800/80 text-[10px] sm:text-[11px] text-slate-400 flex justify-between font-sans">
                                <span>Response Time: 240ms</span>
                                <span>Format: JSON</span>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Interactive Quick Diagnosis Demo Section -->
        <section id="demo" class="py-16 sm:py-20 bg-slate-900/60 border-t border-slate-800/80 relative">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="glass-panel rounded-3xl p-6 sm:p-12 border border-slate-800 text-center relative overflow-hidden shadow-2xl">
                    
                    <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-2xl sm:rounded-3xl bg-gradient-to-tr from-teal-400 to-sky-400 text-slate-950 flex items-center justify-center mx-auto mb-4 sm:mb-6 shadow-lg shadow-teal-500/25">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <h2 class="text-xl sm:text-3xl font-extrabold text-white mb-2 sm:mb-3">
                        جاهز لبدء تجربة دكتور حكيم؟
                    </h2>
                    <p class="text-slate-300 text-xs sm:text-base max-w-xl mx-auto mb-6 sm:mb-8">
                        يمكنك التواصل مع التطبيق أو استخدام واجهة المريض للبدء في إجراء الفحص الطبي الأول وحفظ السجلات الجلدية الخاصة بك.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 sm:gap-4">
                        <button onclick="alert('منصة دكتور حكيم تعمل الآن كأنظمة API وواجهات متكاملة. يسعدنا انضمامك!');" class="w-full sm:w-auto px-6 sm:px-8 py-3.5 sm:py-4 text-sm sm:text-base font-bold text-slate-950 bg-gradient-to-r from-teal-400 to-sky-400 hover:from-teal-300 hover:to-sky-300 rounded-2xl shadow-xl shadow-teal-500/25 transition-all">
                            إنشاء حساب مريض جديد
                        </button>
                        <a href="/docs/API_DOCUMENTATION.md" class="w-full sm:w-auto px-6 sm:px-8 py-3.5 sm:py-4 text-sm sm:text-base font-semibold text-slate-300 bg-slate-900 hover:bg-slate-800 border border-slate-700 rounded-2xl transition-colors">
                            استكشاف ملف التوثيق كامل
                        </a>
                    </div>

                </div>

            </div>
        </section>

        <!-- FAQ Section -->
        <section id="faq" class="py-16 sm:py-24 relative">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center mb-12 sm:mb-16">
                    <h2 class="text-xs font-bold text-teal-400 tracking-widest uppercase mb-3">الأسئلة الشائعة</h2>
                    <p class="text-2xl sm:text-3xl font-extrabold text-white">إجابات لكافة استفساراتك حول دكتور حكيم</p>
                </div>

                <div class="space-y-3 sm:space-y-4">
                    
                    <details class="glass-card rounded-2xl p-5 sm:p-6 group [&_summary::-webkit-details-marker]:hidden cursor-pointer">
                        <summary class="flex items-center justify-between text-base sm:text-lg font-bold text-white gap-2">
                            <span>هل يستبدل دكتور حكيم زيارة الطبيب المختص؟</span>
                            <span class="transition group-open:-rotate-180 text-teal-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <p class="mt-3 sm:mt-4 text-slate-300 text-xs sm:text-sm leading-relaxed border-t border-slate-800 pt-3 sm:pt-4">
                            لا، دكتور حكيم هو نظام تشخيص مساند ويعمل كأداة توجيه وتقييم ذكية أولية. يوصى دائماً بزيارة طبيب أمراض جلدية مختص للحصول على الفحص السريري والوصفة الطبية الرسمية.
                        </p>
                    </details>

                    <details class="glass-card rounded-2xl p-5 sm:p-6 group [&_summary::-webkit-details-marker]:hidden cursor-pointer">
                        <summary class="flex items-center justify-between text-base sm:text-lg font-bold text-white gap-2">
                            <span>ما هو كود المريض الموحد PAT-Code؟</span>
                            <span class="transition group-open:-rotate-180 text-teal-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <p class="mt-3 sm:mt-4 text-slate-300 text-xs sm:text-sm leading-relaxed border-t border-slate-800 pt-3 sm:pt-4">
                            هو معرف فريد يُنشأ تلقائياً فور تسجيل المريض (مثل <code class="text-teal-300">PAT-A8F2K1</code>). يُستخدم لربط كافة الفحوصات والتحليلات الطبية المستقبلية الخاصة بالمريض بأمان التام.
                        </p>
                    </details>

                    <details class="glass-card rounded-2xl p-5 sm:p-6 group [&_summary::-webkit-details-marker]:hidden cursor-pointer">
                        <summary class="flex items-center justify-between text-base sm:text-lg font-bold text-white gap-2">
                            <span>كيف يمكن لمطوري التطبيقات الربط مع المنصة؟</span>
                            <span class="transition group-open:-rotate-180 text-teal-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <p class="mt-3 sm:mt-4 text-slate-300 text-xs sm:text-sm leading-relaxed border-t border-slate-800 pt-3 sm:pt-4">
                            يقدم النظام RESTful API مرناً يدعم التوثيق عبر Sanctum Bearer Tokens. يمكنك الاطلاع على الدليل التفصيلي الشامل في مجلد <code class="text-sky-300">docs/API_DOCUMENTATION.md</code>.
                        </p>
                    </details>

                </div>

            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 border-t border-slate-800/80 py-8 sm:py-12 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-right">
                
                <!-- Logo & Copyright -->
                <div class="flex flex-col sm:flex-row items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-teal-400 to-sky-400 p-0.5 shrink-0">
                        <div class="w-full h-full bg-slate-950 rounded-[10px] flex items-center justify-center">
                            <span class="text-teal-400 text-xs font-black">حكيم</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white">منصة دكتور حكيم التشخيصية</p>
                        <p class="text-xs text-slate-500">© 2026 جميع الحقوق محفوظة. تم التطوير باستخدام الذكاء الاصطناعي ولارافيل.</p>
                    </div>
                </div>

                <!-- Footer Navigation -->
                <div class="flex flex-wrap justify-center items-center gap-4 sm:gap-6 text-xs text-slate-400 font-medium">
                    <a href="#about" class="hover:text-teal-400 transition-colors">عن النظام</a>
                    <a href="#features" class="hover:text-teal-400 transition-colors">المميزات</a>
                    <a href="#api-docs" class="hover:text-teal-400 transition-colors">دليل API</a>
                    <a href="/docs/API_DOCUMENTATION.md" target="_blank" class="hover:text-teal-400 transition-colors">التوثيق</a>
                </div>

            </div>
        </div>
    </footer>

    <!-- Interactive JavaScript -->
    <script>
        // Mobile Menu Drawer Toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const hamburger = document.getElementById('hamburger-icon');
            const close = document.getElementById('close-icon');
            
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                hamburger.classList.add('hidden');
                close.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
                hamburger.classList.remove('hidden');
                close.classList.add('hidden');
            }
        }

        // AI Scanner Demo Switcher
        const demoData = {
            eczema: {
                bg: 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=600&q=80',
                disease: 'أكزيما تلامسية خفيفة (Eczema)',
                confidence: '98.4%',
                progress: '98.4%',
                advice: 'ترطيب مستمر وتجنب الصابون المعطر',
                severity: 'خطورة منخفضة',
                severityBg: 'bg-emerald-500/10 text-emerald-400'
            },
            psoriasis: {
                bg: 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=600&q=80',
                disease: 'صدفية لوحية أولية (Psoriasis)',
                confidence: '94.1%',
                progress: '94.1%',
                advice: 'استخدام كريمات مهدئة واستشارة طبيب الجلدية',
                severity: 'خطورة متوسطة',
                severityBg: 'bg-amber-500/10 text-amber-400'
            },
            acne: {
                bg: 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=600&q=80',
                disease: 'حب شباب التهابي (Acne Vulgaris)',
                confidence: '99.0%',
                progress: '99.0%',
                advice: 'غسول محتوى على حمض الساليسيليك',
                severity: 'خطورة منخفضة',
                severityBg: 'bg-emerald-500/10 text-emerald-400'
            }
        };

        function switchDemo(type) {
            const data = demoData[type];
            if (!data) return;

            const statusText = document.getElementById('scan-status-text');
            statusText.innerText = 'جاري إعادة تحليل العينة...';

            setTimeout(() => {
                document.getElementById('scanner-bg').style.backgroundImage = `linear-gradient(rgba(15,23,42,0.6), rgba(15,23,42,0.6)), url('${data.bg}')`;
                document.getElementById('res-disease').innerText = data.disease;
                document.getElementById('res-confidence').innerText = data.confidence;
                document.getElementById('res-progress').style.width = data.progress;
                document.getElementById('res-advice').innerText = data.advice;
                
                const sevElem = document.getElementById('res-severity');
                sevElem.innerText = data.severity;
                sevElem.className = `text-[10px] px-2 py-0.5 rounded font-semibold shrink-0 ${data.severityBg}`;

                statusText.innerText = 'تم اكتمال الفحص بنجاح';
            }, 400);
        }
    </script>
</body>
</html>

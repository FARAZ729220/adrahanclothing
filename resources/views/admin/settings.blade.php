<x-admin.layout>


    <div class="container page-wrap">

        <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between mb-4">
            <div>
                <h2 class="page-title m-0">Settings</h2>
                <div class="page-subtitle">Manage shipping fee and homepage hero carousel content.</div>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost">← Back to Dashboard</a>
        </div>

        {{-- SUCCESS / ERRORS --}}
        @if (session('success'))
            <div class="alertx mb-3">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="errorx mb-3">
                <div class="fw-bold mb-1">Please fix the following:</div>
                <ul class="m-0 ps-3">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">

                {{-- SHIPPING --}}
                <div class="col-lg-5">
                    <div class="cardx">
                        <div class="cardx-h">
                            <div class="fw-black fw-bold">Shipping</div>
                            <div class="muted">Set shipping fee or enable free shipping.</div>
                        </div>

                        <div class="cardx-b">

                            <div class="mb-3">
                                <label>Shipping Fee (PKR)</label>
                                <input type="number" name="shipping_fee" min="0"
                                    value="{{ old('shipping_fee', $settings->shipping_fee ?? 200) }}"
                                    class="form-control" />
                                <div class="help">Example: 200. If Free Shipping enabled, fee will be ignored.</div>
                            </div>

                            <div class="mb-2">
                                <label>Free Shipping</label>
                                <div class="switch-wrap">
                                    <div class="form-check form-switch m-0">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            name="free_shipping"
                                            {{ old('free_shipping', $settings->free_shipping ?? false) ? 'checked' : '' }}>
                                    </div>
                                    <div>
                                        <div class="fw-bold">Enable Free Shipping</div>
                                        <div class="small-note">When ON, checkout shipping becomes Rs 0.</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- HERO TEXT --}}
                <div class="col-lg-7">
                    <div class="cardx">
                        <div class="cardx-h">
                            <div class="fw-bold">Homepage Hero Content</div>
                            <div class="muted">Update title, subtitle and description shown on hero section.</div>
                        </div>

                        <div class="cardx-b">
                            <div class="mb-3">
                                <label>Hero Subtitle</label>
                                <input type="text" name="hero_subtitle"
                                    value="{{ old('hero_subtitle', $settings->hero_subtitle ?? 'New Season Collection') }}"
                                    class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label>Hero Title</label>
                                <input type="text" name="hero_title"
                                    value="{{ old('hero_title', $settings->hero_title ?? 'Your Style. Your Rules.') }}"
                                    class="form-control" />
                                <div class="help">Tip: you can add line breaks in blade if you want later.</div>
                            </div>

                            <div class="mb-0">
                                <label>Hero Description</label>
                                <textarea name="hero_description" rows="3" class="form-control">{{ old('hero_description', $settings->hero_description ?? 'Discover the freshest collection crafted for the modern wardrobe.') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- HERO IMAGES --}}
                <div class="col-12">
                    <div class="cardx">
                        <div class="cardx-h">
                            <div class="fw-bold">Hero Carousel Images</div>
                            <div class="muted">Upload up to 3 images. Carousel will auto-rotate (no arrows).</div>
                        </div>

                        <div class="cardx-b">
                            <div class="row g-4">

                                {{-- Image 1 --}}
                                <div class="col-md-4">
                                    <label>Hero Image 1</label>

                                    <div class="preview mb-2">
                                        @if (!empty($settings->hero_image_1))
                                            <img src="{{ asset('storage/' . $settings->hero_image_1) }}" alt="Hero 1">
                                        @else
                                            <div class="small-note">No image uploaded</div>
                                        @endif
                                    </div>

                                    <input type="file" name="hero_image_1" accept="image/*" class="form-control">
                                    <div class="help">Recommended: 1600×900 or higher.</div>
                                </div>

                                {{-- Image 2 --}}
                                <div class="col-md-4">
                                    <label>Hero Image 2</label>

                                    <div class="preview mb-2">
                                        @if (!empty($settings->hero_image_2))
                                            <img src="{{ asset('storage/' . $settings->hero_image_2) }}"
                                                alt="Hero 2">
                                        @else
                                            <div class="small-note">No image uploaded</div>
                                        @endif
                                    </div>

                                    <input type="file" name="hero_image_2" accept="image/*" class="form-control">
                                    <div class="help">Optional.</div>
                                </div>

                                {{-- Image 3 --}}
                                <div class="col-md-4">
                                    <label>Hero Image 3</label>

                                    <div class="preview mb-2">
                                        @if (!empty($settings->hero_image_3))
                                            <img src="{{ asset('storage/' . $settings->hero_image_3) }}"
                                                alt="Hero 3">
                                        @else
                                            <div class="small-note">No image uploaded</div>
                                        @endif
                                    </div>

                                    <input type="file" name="hero_image_3" accept="image/*" class="form-control">
                                    <div class="help">Optional.</div>
                                </div>

                            </div>

                            <div class="d-flex flex-wrap gap-2 justify-content-end mt-4">
                                <button type="submit" class="btn btn-purple">Save Settings</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>

</x-admin.layout>

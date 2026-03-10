<x-admin.layout>

    <main class="flex-grow-1 p-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white fw-black m-0">Contact Details</h2>

            <a href="{{ route('admin.contacts') }}" type="button" class="btn btn-secondary">
                <i class="bi bi-arrow me-2"></i> Back
            </a>
        </div>


        <h3 class="text-white">Name:</h3>
        <p class="text-white"><strong>{{ $contact->name }}</strong></p>

        <hr style="color:

        red">

        <h3 class="text-white">Phone:</h3>
        <p class="text-white"><strong>{{ $contact->phone }}</strong></p>

        <hr style="color:

        red">

        <h3 class="text-white">Email:</h3>
        <p class="text-white"><strong>{{ $contact->email }}</strong></p>

        <hr style="color:

        red">

        <h3 class="text-white">Message:</h3>

        <p class="text-white">
            {{ $contact->description }}

        </p>


        <hr style="color:

        red">
        @if ($contact->proof_image)
            <img src="{{ asset('storage/' . $contact->proof_image) }}" class="w-50" style="border-radius:6px;">
        @endif
    </main>


</x-admin.layout>

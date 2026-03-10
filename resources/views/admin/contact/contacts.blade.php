<x-admin.layout>


    <main class="flex-grow-1 p-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white fw-black m-0">Contacts Leads/Enquiry</h2>


        </div>

        <div class="table-responsive">
            <table class="table table-dark custom-admin-table align-middle" id="contact-table">
                <thead>
                    <tr>
                        <th class="text-secondary small fw-bold border-0">Name</th>
                        <th class="text-secondary small fw-bold border-0">Image</th>
                        <th class="text-secondary small fw-bold border-0">Date</th>
                        <th class="text-secondary small fw-bold border-0">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                        <tr>
                            <td>{{ $contact->name }}</td>
                            <td>
                                @if ($contact->proof_image)
                                    <img src="{{ asset('storage/' . $contact->proof_image) }}" width="50"
                                        style="border-radius:6px;">
                                @else
                                    No Image
                                @endif
                            </td>

                            <td class="fw-bold">{{ $contact->created_at->format('d M Y') }}</td>
                            <td class="fw-bold">


                                <form method="POST" action="{{ route('contact.destroy', $contact->id) }}"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger contact-delete-btn"
                                        data-id="{{ $contact->id }}">
                                        🗑️
                                    </button>
                                </form>

                                <a href="{{ route('admin.contacts.details', $contact->id) }}"
                                    class="btn btn-secondary"><i class="bi bi-eye"></i></a>
                            </td>

                        </tr>
                    @empty
                        <p>No Contacts/Enquiry at the moment</p>
                    @endforelse

                </tbody>
            </table>
        </div>
    </main>

</x-admin.layout>


<script>
    let contactTable;

    $(document).ready(function() {

        // Initialize DataTable
        contactTable = $('#contact-table').DataTable();

        // Delete contact
        $(document).on('click', '.contact-delete-btn', function() {

            const button = $(this);
            const form = button.closest('form');
            const row = button.closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "This contact will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(),
                        success: function() {

                            contactTable.row(row).remove().draw();

                            Swal.fire(
                                'Deleted!',
                                'Contact has been deleted.',
                                'success'
                            );
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'Something went wrong.',
                                'error'
                            );
                        }
                    });

                }
            });
        });

    });
</script>

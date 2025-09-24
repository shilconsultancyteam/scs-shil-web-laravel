@extends('layouts.admin_panel')

@section('content')
    <div class="container mx-auto px-4">
        <div class="card-bg rounded-xl p-8 md:p-12 mb-8">
            <h1 class="text-3xl md:text-4xl font-bold gradient-text mb-4">Job Applicants</h1>
            <p class="text-gray-400">View and manage all incoming job applications.</p>
        </div>

        <div class="overflow-x-auto card-bg rounded-xl p-6">
            <table class="w-full text-left table-custom">
                <thead>
                    <tr class="bg-dark-3 text-gray-400 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Post Name</th>
                        <th class="py-3 px-6 text-left">Applicant Name</th>
                        <th class="py-3 px-6 text-left">Email</th>
                        <th class="py-3 px-6 text-left">Phone</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300 text-sm font-light">
                    @forelse ($applicants as $applicant)
                        <tr class="border-b border-gray-700 hover:bg-dark-3">
                            <td class="py-3 px-6 whitespace-nowrap">{{ $applicant->job->post_name }}</td>
                            <td class="py-3 px-6">{{ $applicant->name }}</td>
                            <td class="py-3 px-6">{{ $applicant->email }}</td>
                            <td class="py-3 px-6">{{ $applicant->phone }}</td>
                            <td class="py-3 px-6 text-center">
                                <a href="#" onclick="showApplicantDetails({{ json_encode($applicant) }})" class="text-cyan-400 hover:text-cyan-300 mr-2" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ asset('storage/' . $applicant->cv_path) }}" download class="text-purple-400 hover:text-purple-300" title="Download CV">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-500">No applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="applicant-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 hidden z-50">
        <div class="card-bg w-full max-w-2xl rounded-xl p-8 relative">
            <button onclick="hideApplicantDetails()" class="absolute top-4 right-4 text-gray-400 hover:text-white"><i class="fas fa-times"></i></button>
            <h3 class="text-2xl font-bold gradient-text mb-6">Applicant Details</h3>
            <div id="modal-content" class="space-y-4">
                </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function showApplicantDetails(applicant) {
        const modal = document.getElementById('applicant-modal');
        const content = document.getElementById('modal-content');
        content.innerHTML = `
            <p><strong>Job Applied For:</strong> ${applicant.job.post_name}</p>
            <p><strong>Name:</strong> ${applicant.name}</p>
            <p><strong>Email:</strong> ${applicant.email}</p>
            <p><strong>Phone:</strong> ${applicant.phone}</p>
            <p><strong>Portfolio Link:</strong> <a href="${applicant.portfolio_link}" target="_blank" class="text-cyan-400 hover:underline">${applicant.portfolio_link}</a></p>
            <p><strong>Cover Letter:</strong></p>
            <div class="card-bg p-4 rounded-lg border border-gray-700">
                <p class="whitespace-pre-wrap">${applicant.cover_letter}</p>
            </div>
            <a href="/storage/${applicant.cv_path}" download class="btn-glow inline-block px-6 py-2 bg-gradient-to-r from-purple-600 to-cyan-500 text-white rounded-full font-semibold shadow-lg hover:shadow-xl transition duration-300 mt-4">
                <i class="fas fa-download mr-2"></i> Download CV
            </a>
        `;
        modal.classList.remove('hidden');
    }

    function hideApplicantDetails() {
        document.getElementById('applicant-modal').classList.add('hidden');
    }
</script>
@endpush
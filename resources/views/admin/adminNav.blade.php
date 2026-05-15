<aside class="bg-gray-800 text-white w-64 min-h-screen">
    <div class="flex flex-col items-center justify-center h-24 border-b border-gray-700">
        <p class="text-2xl font-bold">Welcome, Admin</p>
    </div>
    <hr>
    <ul class="flex flex-col space-y-2 p-4">
        <li><a class="block px-4 py-2 rounded hover:bg-gray-700" href="#">Home</a></li>
        <li><a class="block px-4 py-2 rounded hover:bg-gray-700" href="{{ route('residents.index') }}">Residents</a></li>
        <li><a class="block px-4 py-2 rounded hover:bg-gray-700" href="{{ route('officials.index') }}">Officials</a></li>
        <li><a class="block px-4 py-2 rounded hover:bg-gray-700" href="{{ route('official_titles.index') }}">Titles</a></li>
        <li><a class="block px-4 py-2 rounded hover:bg-gray-700" href="{{ route('certificate_details.index') }}">Certificates</a></li>
        <li><a class="block px-4 py-2 rounded hover:bg-gray-700" href="{{ route('certificate_types.index') }}">Certificate Types</a></li>
        <li><a class="block px-4 py-2 rounded hover:bg-gray-700" href="{{ route('complaint_details.index') }}">Complaints</a></li>
        <li><a class="block px-4 py-2 rounded hover:bg-gray-700" href="{{ route('complaint_types.index') }}">Complaint Types</a></li>
        <li><a class="block px-4 py-2 rounded hover:bg-gray-700" href="{{ route('fines.index') }}">Fines</a></li>
        <li><a class="block px-4 py-2 rounded hover:bg-gray-700" href="{{ route('violations.index') }}">Violations</a></li>
        <li><a class="block px-4 py-2 rounded hover:bg-gray-700" href="{{ route('project_details.index') }}">Projects</a></li>
        <li><a class="block px-4 py-2 rounded hover:bg-gray-700" href="{{ route('project_types.index') }}">Project Types</a></li>
        <li><a class="block px-4 py-2 rounded hover:bg-gray-700" href="{{ route('transaction_details.index') }}">Transactions</a></li>
        <li><a class="block px-4 py-2 rounded hover:bg-gray-700" href="{{ route('transaction_types.index') }}">Transaction Types</a></li>
        <li><a class="block px-4 py-2 rounded hover:bg-gray-700" href="{{ route('users.index') }}">Staff</a></li>
        <li><a class="block px-4 py-2 rounded hover:bg-gray-700" href="{{ route('statuses.index') }}">Status</a></li>
    </ul>
</aside>

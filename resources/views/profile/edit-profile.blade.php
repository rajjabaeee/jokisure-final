{{-- resources/views/profile/edit-profile.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>JokiSure • Edit Profile</title>

  {{-- Bootstrap (sesuai original) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- CSS kamu yang sama persis --}}
  <link href="{{ asset('css/edit-profile.css') }}" rel="stylesheet">
</head>
<body class="preview-center">
<main class="device-frame" role="main" aria-label="Edit Profile">

  {{-- STATUS BAR (mock iOS) --}}
  <div class="status-bar d-flex align-items-center justify-content-between px-3">
    <div class="time">9:41</div>
    <div class="status-icons d-flex align-items-center gap-2">
      <svg width="20" height="12" viewBox="0 0 20 12" fill="none"><rect x="1" y="7" width="2" height="4" rx=".75" fill="#0a0a0a"/><rect x="5" y="5" width="2" height="6" rx=".75" fill="#0a0a0a"/><rect x="9" y="3" width="2" height="8" rx=".75" fill="#0a0a0a"/><rect x="13" y="1" width="2" height="10" rx=".75" fill="#0a0a0a"/></svg>
      <svg width="18" height="12" viewBox="0 0 18 12" fill="none"><path d="M9 9.5c.7 0 1.25.55 1.25 1.25S9.7 12 9 12 7.75 11.45 7.75 10.75 8.3 9.5 9 9.5Z" fill="#0a0a0a"/><path d="M3 6.5c3.9-3.2 8.1-3.2 12 0" stroke="#0a0a0a" stroke-width="1.6" stroke-linecap="round"/><path d="M5.6 8c2.53-2.05 4.27-2.05 6.8 0" stroke="#0a0a0a" stroke-width="1.6" stroke-linecap="round"/></svg>
      <svg width="26" height="12" viewBox="0 0 26 12" fill="none"><rect x="1" y="1" width="20" height="10" rx="2" stroke="#0a0a0a" stroke-width="1.5"/><rect x="3" y="3" width="16" height="6" rx="1.5" fill="#0a0a0a"/><rect x="22" y="4" width="3" height="4" rx="1" fill="#0a0a0a"/></svg>
    </div>
  </div>

  {{-- SAFE AREA --}}
  <section class="safe-area">

    {{-- APP BAR --}}
    <div class="appbar d-flex align-items-center justify-content-between px-3">
      <a href="{{ url()->previous() }}" class="icon-btn" aria-label="Back">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M6 12h12M10 8l-4 4 4 4" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
      <div class="fw-semibold">Edit Profile</div>
      {{-- Tombol save hanya submit ke route mock (tanpa DB) --}}
      <button form="editProfileForm" class="btn btn-save">Save</button>
    </div>

    {{-- CONTENT --}}
    <div class="container px-3 pb-5">

      {{-- AVATAR SELECTOR --}}
      <div class="d-flex justify-content-center mt-3">
        <div class="avatar-wrap">
          {{-- Display user's profile picture or default --}}
          <img src="{{ $user->user_profile_pic ? asset('storage/' . $user->user_profile_pic) : asset('assets/Tamago.jpg') }}" alt="avatar">
          <label class="avatar-upload" title="Change photo">
            <input type="file" accept="image/*" name="profile_pic" hidden>
            <svg viewBox="0 0 24 24"><path d="M4 7h3l2-2h6l2 2h3v12H4V7Z" fill="#fff" stroke="#c9c9c9"/><path d="M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z" fill="none" stroke="#c9c9c9"/></svg>
          </label>
        </div>
      </div>

      {{-- FORM (with DB integration) --}}
      <form id="editProfileForm" class="mt-3" method="POST" action="{{ route('profile.update.mock') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label class="form-label">Name<span class="req">*</span></label>
          <input type="text" class="form-control" name="name" placeholder="Enter your name" value="{{ $user->user_name ?? '' }}">
        </div>

        <div class="mb-3">
          <label class="form-label">Nametag<span class="req">*</span></label>
          <input type="text" class="form-control" name="nametag" placeholder="@yourname" value="{{ $user->user_nametag ? '@' . $user->user_nametag : '' }}">
        </div>

        <div class="mb-3">
          <label class="form-label">Phone Number<span class="req">*</span></label>
          <div class="input-group">
            <span class="input-group-text">+62</span>
            <input type="tel" class="form-control" name="phone" placeholder="812345678" value="{{ $user->user_number ? str_replace('+62', '', $user->user_number) : '' }}">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Email<span class="req">*</span></label>
          <input type="email" class="form-control" name="email" placeholder="your@email.com" value="{{ $user->user_email ?? '' }}">
        </div>
      </form>
    </div>
  </section>

  {{-- HOME INDICATOR --}}
  <div class="home-indicator" aria-hidden="true"></div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

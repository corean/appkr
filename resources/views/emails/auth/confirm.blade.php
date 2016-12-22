{{ $user->name }}님, 환영합니다.

가입확인을 위해브라우저에서 다음 주소를 열어주세요.

{{ route('users.confirm', $user->confirm_code) }}
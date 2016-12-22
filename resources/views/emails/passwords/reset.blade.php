{{ config('app.name') }} - 비밀번호 초기화 요청

비밀번호 초기화가입확인을 위해 브라우저에서 다음 주소를 열어주세요.

{{ route('reset.create', $token) }}


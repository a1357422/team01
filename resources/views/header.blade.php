<nav class="navbar navbar-expand-lg navbar-light bg-light dashboard">
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      @canany(['chief','floorhead'])
      <li class="nav-item">
        <a class="nav-link" href="/sbrecords">學生床位系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/rollcalls">點名系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/lates">晚歸系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/leaves">外宿系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/users/{{Auth::user()->id}}/change_pw">修改密碼</a>
      </li>
      @endcanany
      @can('superadmin')
      <li class="nav-item">
        <a class="nav-link" href="/users">後臺管理系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/students">學生系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/beds">床位系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/dormitories">宿舍系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/sbrecords">學生床位系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/rollcalls">點名系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/lates">晚歸系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/leaves">外宿系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/users/{{Auth::user()->id}}/change_pw">修改密碼</a>
      </li>
      @elsecan('admin')
      <li class="nav-item">
        <a class="nav-link" href="/students">學生系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/beds">床位系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/dormitories">宿舍系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/sbrecords">學生床位系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/lates">晚歸系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/leaves">外宿系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/users/{{Auth::user()->id}}/change_pw">修改密碼</a>
      </li>
      @elsecan('housemaster')
      <li class="nav-item">
        <a class="nav-link" href="/sbrecords">學生床位系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/lates">晚歸系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/leaves">外宿系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/users/{{Auth::user()->id}}/change_pw">修改密碼</a>
      </li>
      @elsecan('user') <!--住宿生-->
      <li class="nav-item">
      <li class="nav-item">
        <a class="nav-link" href="/lates">晚歸系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/leaves">外宿系統</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/users/{{Auth::user()->id}}/change_pw">修改密碼</a>
      </li>
      @endcan
</div>
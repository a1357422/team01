<div class="head">
@canany(['chief','floorhead']) <!--總樓長、樓長-->
            <ui class="dashboard">
                <li><a href = "/sbrecords">學生床位系統</a></li>
                <li><a href = "/rollcalls">點名系統</a></li>
                <li><a href = "/lates">晚歸系統</a></li>
                <li><a href = "/leaves">外宿系統</a></li>
                <li><a href = "/users/{{Auth::user()->id}}/change_pw">修改密碼</a></li>
            </ui>
        @endcanany
        @can('superadmin') <!--系統後台管理員-->
            <ui class="dashboard">
                <li><a href = "/users">後臺管理系統</a></li>
                <li><a href = "/students">學生系統</a></li>
                <li><a href = "/beds">床位系統</a></li>
                <li><a href = "/dormitories">宿舍系統</a></li>
                <li><a href = "/sbrecords">學生床位系統</a></li>
                <li><a href = "/rollcalls">點名系統</a></li>
                <li><a href = "/lates">晚歸系統</a></li>
                <li><a href = "/leaves">外宿系統</a></li>
                <li><a href = "/users/{{Auth::user()->id}}/change_pw">修改密碼</a></li>
            </ui>
        @elsecan('admin') <!--宿舍行政-->
            <ui class="dashboard">
                <li><a href = "/students">學生系統</a></li>
                <li><a href = "/beds">床位系統</a></li>
                <li><a href = "/dormitories">宿舍系統</a></li>
                <li><a href = "/sbrecords">學生床位系統</a></li>
                <li><a href = "/lates">晚歸系統</a></li>
                <li><a href = "/leaves">外宿系統</a></li>
                <li><a href = "/users/{{Auth::user()->id}}/change_pw">修改密碼</a></li>
            </ui>
        @elsecan('housemaster') <!--宿舍輔導員-->
            <ui class="dashboard">
                <li><a href = "/sbrecords">學生床位系統</a></li>
                <li><a href = "/lates">晚歸系統</a></li>
                <li><a href = "/leaves">外宿系統</a></li>
                <li><a href = "/users/{{Auth::user()->id}}/change_pw">修改密碼</a></li>
            </ui>
        @elsecan('user') <!--住宿生-->
            <ui class="dashboard">
                <li><a href = "/lates">晚歸系統</a></li>
                <li><a href = "/leaves">外宿系統</a></li>
                <li><a href = "/users/{{Auth::user()->id}}/change_pw">修改密碼</a></li>
            </ui>
        @endcan
</div>
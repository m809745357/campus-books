<div style="height: 1.32rem"></div>
<div class="menu con">
    <li><a href="{{ route('threads.index') }}" class="menu-item"><img src="/images/home.png" alt="">首页</a></li>
    <li><a href="{{ route('threads.index') }}" class="menu-item"><img src="/images/post.png" alt="">发布</a></li>
    <li><a href="{{ route('threads.index') }}" class="menu-item"><img src="/images/thread.png" alt="">问答</a></li>
    <li><a href="{{ route('user.index', ['user' => auth()->user()]) }}" class="menu-item"><img src="/images/user-on.png" alt="">我的</a></li>
</div>

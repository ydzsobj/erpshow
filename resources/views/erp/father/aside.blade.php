<div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
          <div class="layui-logo" lay-href="/admin/index">
              <i class="layui-icon">&#xe857;</i>
              <span> 仓储数据管理系统</span>
          </div>           
          <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
             <li data-name="home" class="layui-nav-item layui-nav-itemed">
              <a href="javascript:;" lay-tips="主页" lay-direction="2">
                <i class="layui-icon layui-icon-home"></i>
                <cite>主页</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="console" class="layui-this">
                  <a lay-href="home/console.html"><i class="layui-icon">&#xe629;</i>监控台</a>
                </dd>
              </dl>
            </li>
            @foreach($rules as $v)
              @if($v->rule_level==='0' && $v->rule_system===2)
              <li data-name="home" class="layui-nav-item">
              <a href="javascript:;" lay-tips="主页" lay-direction="2">
                  <i class="layui-icon">{!! $v->rule_icon !!}</i>
                  <cite>{{$v->rule_name}}</cite>
              </a>
              <dl class="layui-nav-child">
                @foreach($rules as $val)
                  @if($val->rule_level==$v->rule_id && $val->rule_system===2)
                    <dd data-name="console" class="">
                      <a lay-href="{{$val->rule_url}}">{{$val->rule_name}}</a>
                    </dd>
                  @endif
                @endforeach
              </dl>
            </li>
              @endif
            @endforeach
             <li data-name="home" class="layui-nav-item ">
              <a href="javascript:;" lay-tips="辅助工具" lay-direction="2">
                <i class="layui-icon layui-icon-util"></i>
                <cite>辅助工具</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="console" >
                  <a lay-href="http://baidu.com">Baidu</a>
                </dd>
                <dd data-name="console">
                  <a lay-href="/admins/jsq">科学计算器</a>
                </dd>
              </dl>
            </li>
          </ul>
        </div>
      </div>




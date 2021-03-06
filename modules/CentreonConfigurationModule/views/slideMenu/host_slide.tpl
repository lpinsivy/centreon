<div class="headerWrapper">
    <div class="row">
        <div class="iconWrapper col-md-2">
            <i class="icon-host"></i>
        </div>
        <h4 class="col-md-8">{{hostConfig.name}}</h4>
        <div class="iconWrapper col-md-2">
            <a href="{{edit_url}}" alt=""><i class="icon-edit"></i></a>
        </div>
    </div>
    <div class="row">
        <div class="stateWrapper col-md-2">
            <ul>
                <li>
                     <i class="icon-service success"></i>
                     <strong>{{servicesStatus.success}}</strong>
                </li>
                 <li>
                     <i class="icon-service warning"></i>
                     <strong>{{servicesStatus.warning}}</strong>
                </li>
                 <li>
                     <i class="icon-service danger"></i>
                     <strong>{{servicesStatus.danger}}</strong>
                </li>

            </ul>
        </div>
        <div class="detailsWrapper col-md-10">
            <table>
                <tr>
                    <td>Command</td>
                    <td>{{hostConfig.command}}</td>
                </tr>

                <tr>
                    <td>Time period</td>
                    <td>{{hostConfig.time_period}}</td>
                </tr>

                <tr>
                    <td>Max check attempts</td>
                    <td>{{hostConfig.max_check_attempts}}</td>
                </tr>

                <tr>
                    <td>Check interval</td>
                    <td>{{hostConfig.check_interval}}</td>
                </tr>

                <tr>
                    <td>Retry check interval</td>
                    <td>{{hostConfig.retry_check_interval}}</td>
                </tr>

                <tr>
                    <td>Active checks enabled</td>
                    <td>{{hostConfig.active_checks_enabled}}</td>
                </tr>

                 <tr>
                    <td>Passive checks enabled</td>
                    <td>{{hostConfig.passive_checks_enabled}}</td>
                </tr>

            </table>
        </div>
    </div>
</div>
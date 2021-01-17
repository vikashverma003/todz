<h3>Payments</h3>
<ul class="detailList">
    <li>
        <h4>Total</h4>
        <p>${{ProjectManager::projectTotalPriceForClient($project->id,$talent->id)}}</p>
        <p style="display: none;">${{ProjectManager::projectTotalPrice($project->id,$talent->id)}}</p>
    </li>
    <li>
        <h4>Paid</h4>
        <p>${{$payments->isNotEmpty() ? $payments->pluck('amount')->sum():0}}</p>
    </li>
    <li>
        <h4>Pending</h4>
        <p>${{(ProjectManager::projectTotalPriceForClient($project->id,$talent->id)) - ($payments->isNotEmpty()?$payments->pluck('amount')->sum():0)}}</p>
    </li>
</ul>
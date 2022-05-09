@inject('categories','Modules\Category\Entities\Category')
@inject('countries','Modules\Areas\Entities\Country')
{!! field()->langNavTabs() !!}

<div class="tab-content">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
        <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
             id="first_{{$code}}">
            {!! field()->text('title['.$code.']',
            __('projects::dashboard.projects.form.title').'-'.$code ,
             optional($project->translate($code))->title,
                  ['data-name' => 'title.'.$code]
             ) !!}
            {!! field()->textarea('description['.$code.']',
            __('projects::dashboard.projects.form.description').'-'.$code ,
             optional($project->translate($code))->description,
                  ['data-name' => 'description.'.$code]
             ) !!}
        </div>
    @endforeach
</div>

{!! field()->select('country_id',__('projects::dashboard.projects.form.country') , pluckModelsCols($countries->get(),'title','id',true)) !!}
{!! field()->multiSelect('categories',__('projects::dashboard.projects.form.categories') , pluckModelsCols($categories->get(),'title','id',true)) !!}
{!! field()->number('amount_to_collect', __('projects::dashboard.projects.form.amount_to_collect')) !!}
{!! field()->file('image', __('projects::dashboard.projects.form.image'), $project->getFirstMediaUrl('images')) !!}
{!! field()->checkBox('status', __('projects::dashboard.projects.form.status')) !!}
@if ($project->trashed())
    {!! field()->checkBox('trash_restore', __('projects::dashboard.projects.form.restore')) !!}
@endif
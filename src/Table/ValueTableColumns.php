<?php namespace Anomaly\FileFieldType\Table;

use Anomaly\FilesModule\File\Contract\FileInterface;

/**
 * Class ValueTableColumns
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\FileFieldType\Table
 */
class ValueTableColumns
{

    /**
     * Handle the columns.
     *
     * @param ValueTableBuilder $builder
     */
    public function handle(ValueTableBuilder $builder)
    {
        $builder->setColumns(
            [
                'entry.preview' => [
                    'heading' => 'anomaly.module.files::field.preview.name'
                ],
                'name'          => [
                    'sort_column' => 'name',
                    'wrapper'     => '
                    <h4>
                        {value.link}
                        <br>
                        <small>{value.disk}://{value.folder}/{value.file}</small>
                        <small>{value.size}{value.keywords}</small>
                    </h4>',
                    'value'       => [
                        'file'     => 'entry.name',
                        'link'     => 'entry.edit_link',
                        'folder'   => 'entry.folder.slug',
                        'keywords' => 'entry.keywords.labels',
                        'disk'     => 'entry.folder.disk.slug',
                        'size'     => function (FileInterface $entry) {
                            if (!in_array($entry->getExtension(), config('anomaly.module.files::mimes.thumbnails'))) {
                                return null;
                            }

                            return '<span class="label label-info">' . $entry->getWidth() . ' x ' . $entry->getHeight(
                            ) . '</span>';
                        }
                    ]
                ]
            ]
        );
    }
}

<?php
trait ExtjsFilesystem
{
    // Grid List:
    public function extGridFilesystem()
    {
        $fs = new Filesystem(null, [ 'upload_dir' => ROOT.'/'.$_GET['upload_dir'] ]);

        $contents = $fs->listContents('', true);
        foreach($contents as $data)
        {
            $data['upload_dir'] = $_GET['upload_dir'];
            $data['size']       = round($data['size'] / 1000, 1). ' KB';
            $data['linkpath']   = HOST.'/'.$_GET['upload_dir'].'/'.$data['path'];

            $response['data'][] = $data;
        }

        list($response['totalCount']) = count($contents);

    	echo json_encode($response);
    }


    // Upload:
    public function extGridFilesystemUpload()
    {
        $fs = new Filesystem(null, [ 'upload_dir' => ROOT.'/'.$_POST['upload_dir'] ]);

        for($i = 0; $i < count($_FILES['files']['name']); $i++)
        {
            // Rename if exists:
            $filename = $_FILES['files']['name'][$i];
            if($fs->has($filename)) $filename = time().'_'.$filename;

            $fs->write($filename, file_get_contents($_FILES['files']['tmp_name'][$i]));
        }

        $response['success'] = true;
        echo json_encode($response);
    }


    // Delete:
    public function extGridFilesystemDelete()
    {
        $data = json_decode($_POST['data'], true);

        $fs = new Filesystem(null, [ 'upload_dir' => ROOT.'/'.$data['upload_dir'] ]);

        if($fs->delete($data['path'])) $response['success'] = true;
        else $response['success'] = false;

        echo json_encode($response);
    }
}

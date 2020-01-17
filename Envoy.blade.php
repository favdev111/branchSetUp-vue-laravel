@servers(['web' => 'psof@psof.com -p 45667'])

@setup
    $repository = 'git@gitlab.com:Poris/branch-setup.git';
    $release_dir = '/home/psof/release';
    $app_dir = '/home/psof/public_html';
@endsetup


@story('deploy')
    clone_repository
    run_composer
    update_symlinks
@endstory

@task('clone_repository')
    rm -rf {{ $release_dir }}
    echo 'Cloning repository'
    git clone --depth 1 {{ $repository }} {{ $release_dir }}
    cd {{ $release_dir }}
    git reset --hard {{ $commit }}
@endtask

@task('run_composer')
    echo "Starting deployment"
    cd {{ $release_dir }}
    composer install --prefer-dist --no-scripts -q -o
@endtask

@task('update_symlinks')
    echo 'Linking .env file'
    cp {{ $release_dir }}/.env.prod {{ $release_dir }}/.env

    echo 'Linking current release'
    ln -nfs {{ $release_dir }}/public {{ $app_dir }}
@endtask
def compress(path)
  gem 'rubyzip'
  require 'zip/zip'
  require 'zip/zipfilesystem'

  path.sub!(%r[/$],'')
  archive = File.join(File.basename(path))+'.zip'
  FileUtils.rm archive, :force=>true

  Zip::ZipFile.open(archive, 'w') do |zipfile|
    Dir["#{path}/**/**"].reject{|f|f==archive}.each do |file|
      zipfile.add(file.sub(path+'/',''),file)
    end
  end
end

desc "Compile to compressed css and copy to WP theme"
task :css do |t|
	system "compass compile compass/"
	FileUtils.cp('compass/stylesheets/screen.css', 'legambiente/assets/stylesheets/style.css');
end

task :package do |t|
	compress('legambiente')
end


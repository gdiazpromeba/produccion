var fso = new ActiveXObject( "Scripting.FileSystemObject" );

function parse(fname) {
    var file = fso.OpenTextFile( fname, 1 );
    ret = file.ReadAll();
    file.Close();
    try {
        eval("(function(){\\n"+ret+"\\n});");
    } catch (e) {
        WScript.Echo("Syntax error parsing " + fname);
        WScript.Echo("  " + e.message);
    }
}

function findJavaScript(folder) {
	WScript.Echo("folder=" + folder);
    for (var fc = new Enumerator(folder.files); !fc.atEnd(); fc.moveNext()) {
        var file=fc.item();
        if (/.js$/.test(file.Name)) {
            parse(file);
        }
    }
    for (var fc = new Enumerator(folder.subfolders); !fc.atEnd(); fc.moveNext()) {
        var subfolder = fc.item();
        if (subfolder.Name == ".svn") continue; // ignore .svn folders
        findJavaScript(subfolder);
    }
}

var rootPath = "/xampp/htdocs/produccion";
var rootFolder = fso.GetFolder(rootPath);

findJavaScript(rootFolder);
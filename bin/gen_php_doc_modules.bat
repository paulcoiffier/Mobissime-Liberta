@ECHO OFF
echo -------------------------------------------------
echo *  Liberta Php modules documentation generation *
echo *          Liberta-PhpApiGen plugin             *
echo -------------------------------------------------
cd ..\
echo * All modules 
echo -------------------------------------------------
call apigen generate --source src/MyCrm/Modules/ --destination doc/php/modules --template-theme=bootstrap
echo -------------------------------------------------
echo * 1/11 - LibertaDataStore
echo -------------------------------------------------
call apigen generate --source src/MyCrm/Modules/LibertaDataStore/ --destination src/MyCrm/Modules/LibertaDataStore/Doc --template-theme=bootstrap
echo -------------------------------------------------
echo * 2/11 - LibertaDocGenerator
echo -------------------------------------------------
call apigen generate --source src/MyCrm/Modules/LibertaDocGenerator/ --destination src/MyCrm/Modules/LibertaDataStore/Doc --template-theme=bootstrap
echo -------------------------------------------------
echo * 3/11 - LibertaMenus
echo -------------------------------------------------
call apigen generate --source src/MyCrm/Modules/LibertaMenus/ --destination src/MyCrm/Modules/LibertaMenus/Doc --template-theme=bootstrap
echo -------------------------------------------------
echo * 4/11 - LibertaModules
echo -------------------------------------------------
call apigen generate --source src/MyCrm/Modules/LibertaModules/ --destination src/MyCrm/Modules/LibertaModules/Doc --template-theme=bootstrap
echo -------------------------------------------------
echo * 5/11 - LibertaQueryBuilder
echo -------------------------------------------------
call apigen generate --source src/MyCrm/Modules/LibertaQueryBuilder/ --destination src/MyCrm/Modules/LibertaQueryBuilder/Doc --template-theme=bootstrap
echo -------------------------------------------------
echo * 6/11 - LibertaTest
echo -------------------------------------------------
call apigen generate --source src/MyCrm/Modules/LibertaTest/ --destination src/MyCrm/Modules/LibertaTest/Doc --template-theme=bootstrap
echo -------------------------------------------------
echo * 7/11 - LibertaTickets
echo -------------------------------------------------
call apigen generate --source src/MyCrm/Modules/LibertaTickets/ --destination src/MyCrm/Modules/LibertaTickets/Doc --template-theme=bootstrap
echo -------------------------------------------------
echo * 8/11 - LibertaTodos
echo -------------------------------------------------
call apigen generate --source src/MyCrm/Modules/LibertaTodos/ --destination src/MyCrm/Modules/LibertaTodos/Doc --template-theme=bootstrap
echo -------------------------------------------------
echo * 9/11 - LibertaUserProfile
echo -------------------------------------------------
call apigen generate --source src/MyCrm/Modules/LibertaUserProfile/ --destination src/MyCrm/Modules/LibertaUserProfile/Doc --template-theme=bootstrap
echo -------------------------------------------------
echo * 10/11 - LibertaUsers
echo -------------------------------------------------
call apigen generate --source src/MyCrm/Modules/LibertaUsers/ --destination src/MyCrm/Modules/LibertaUsers/Doc --template-theme=bootstrap
echo -------------------------------------------------
echo * 11/11 - LibertaVisualBuilder
echo -------------------------------------------------
call apigen generate --source src/MyCrm/Modules/LibertaVisualBuilder/ --destination src/MyCrm/Modules/LibertaVisualBuilder/Doc --template-theme=bootstrap
echo -------------------------------------------------
/* test.c */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/stat.h>
#include <sys/types.h>
#include <sys/time.h>
#include <unistd.h>
#include <errno.h>
#include <fcntl.h>
#include <syslog.h>
#include <signal.h>
#include <iostream>
#include <string>
#include <fstream>
#include <unistd.h>
#include <cstdlib>

using namespace std;

int Daemon(void);
char* getTime();
int writeLog(char msg[256]);
char* getCommand(char command[128]);

char* getTime() { //функция возвращает форматированную дату и время
    time_t now;
    struct tm *ptr;
    static char tbuf[64];
    bzero(tbuf,64);
    time(&now);
    ptr = localtime(&now);
    strftime(tbuf,64, "%Y-%m-%e %H:%M:%S", ptr);
    return tbuf;
}

char* getCommand(char command[128]) { //функция возвращает результат выполнения linux команды
    FILE *pCom;
    static char comText[256];
    bzero(comText, 256);
    char  buf[64];
    pCom = popen(command, "r"); //выполняем
    if(pCom == NULL) {
        writeLog("Error Command");
        return "";
    }
    strcpy(comText, "");
    while(fgets(buf, 64, pCom) != NULL) { //читаем результат
        strcat(comText, buf);
    }
    pclose(pCom);
    return comText;
}

int writeLog(char msg[256]) { //функция записи строки в лог
    FILE * pLog;
    pLog = fopen("daemon.log", "a");
    if(pLog == NULL) {
        return 1;
    }
    char str[312];
    bzero(str, 312);
    strcpy(str, getTime());
    strcat(str, " ==========================\n");
    strcat(str, msg);
    strcat(str, "\n");
    fputs(str, pLog);
    //fwrite(msg, 1, sizeof(msg), pLog);
    fclose(pLog);
    return 0;
}

int main(int argc, char* argv[]) {
    writeLog("Daemon Start");

    pid_t parpid, sid;
    
    parpid = fork(); //создаем дочерний процесс
    if(parpid < 0) {
        exit(1);
    } else if(parpid != 0) {
        exit(0);
    } 
    umask(0);//даем права на работу с фс
    sid = setsid();//генерируем уникальный индекс процесса
    if(sid < 0) {
        exit(1);
    }
    if((chdir("/")) < 0) {//выходим в корень фс
        exit(1);
    }
    close(STDIN_FILENO);//закрываем доступ к стандартным потокам ввода-вывода
    close(STDOUT_FILENO);
    close(STDERR_FILENO);
    
    return Daemon();
}

int Daemon(void) { //собственно наш бесконечный цикл демона
    char *log;
    while(1) {
   	string s;
	if (access("/var/www/syn.su/public/tools/daemondead.txt", F_OK))  {  
	} else {
		ifstream file("/var/www/syn.su/public/tools/daemondead.txt"); 

	    getline(file, s);

	    pid_t pidkill= atoi(s.c_str());

	    file.close();

   		kill(pidkill, SIGKILL);

	   // std::cout<<"Pid: "<<s<<std::endl;
    	
		unlink("/var/www/syn.su/public/tools/daemondead.txt");
	}
        sleep(1);
    }
    return 0;
}